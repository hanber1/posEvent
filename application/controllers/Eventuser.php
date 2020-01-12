<?php

class Eventuser extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Festmitarbeiter';
		$this->load->model('model_eventuser');
		$this->load->model('model_eventfunction');
		$this->load->model('model_users');
		$this->load->model('model_cashbook');
		$this->load->model('model_eventday');
	}

	public function index()
	{
		$users = $this->model_users->getActive();
		$this->data['users'] = $users;
		if ($this->session->userdata('id') == 1) {
			$usersEvent = $this->model_users->getActive();
			$this->data['usersEvent'] = $usersEvent;
		} else {
			$usersEvent = $this->model_users->getFreeEventday($this->session->userdata('eventday'));
			$this->data['usersEvent'] = $usersEvent;
		}

		$countActEventUser = $this->model_eventuser->countActive();
		$this->data['countActEvUs'] = $countActEventUser;
		if ($this->session->userdata('id') == 1) {
			$eventdayEvent = $this->model_eventday->getActiveEvent();
			$this->data['eventdayEvent'] = $eventdayEvent;
		} else {
			$eventdayEvent = $this->model_eventday->getActiveEvent($this->session->userdata('eventday'));
			$this->data['eventdayEvent'] = $eventdayEvent;
		}
		$eventfunction = $this->model_eventfunction->getActive();
		$this->data['eventfunction'] = $eventfunction;
		$this->render_template('eventuser/index', $this->data);
	}

	public function fetchData()
	{
		//if(!in_array('viewEventuser', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$result = array('data' => array());

		if ($this->session->userdata('id') == 1) {
			$data = $this->model_eventuser->getData();
		} else {
			$data = $this->model_eventuser->getDataEventday($this->session->userdata('eventday'));
		}

		foreach ($data as $key => $value) {

			$user_data = $this->model_users->getUserData($value['idMitarbeiter']);
			$eventday_data = $this->model_eventday->getEventdayEventData($value['idFesttag']);
			$event_function = $this->model_eventfunction->getData($value['idFestfunktion']);

			// button
			$buttons = '';

			if (in_array('updateEventuser', $this->permission) && ($user_data['status'] == 1)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if (in_array('deleteEventuser', $this->permission) && ($user_data['status'] == 1)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			if (($value['status'] == 1) && ($user_data['status'] == 1)) {
				$buttons .= ' <button type="button" class="btn btn-success" onclick="activateFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#activateModal" title="In Dienst setzen"><i class="fa fa-sign-out"></i></button>';
			}

			if (($value['status'] == 2) && ($user_data['status'] == 1)) {
				$buttons .= ' <button type="button" class="btn btn-info" onclick="cashupFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#cashupModal" title="Abrechnen"><i class="fa fa-sign-in"></i></button>';
			}

			if (($value['status'] == 3) && ($user_data['status'] == 1)) {
				$buttons .= ' <button type="button" class="btn btn-warning" onclick="undoFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#undoModal" title="Wieder aktivieren"><i class="fa fa-undo"></i></button>';
			}

			if ($value['status'] == 1) {
				$status = '<span class="label label-warning">Ausser Dienst</span>';
			} elseif ($value['status'] == 2) {
				$status = '<span class="label label-success">In Dienst</span>';
			} elseif ($value['status'] == 3) {
				$status = '<span class="label label-primary">Abgerechnet</span>';
			} {
				# code...
			}

			$result['data'][$key] = array(
				$user_data['name'] . " " . $user_data['vorname'],
				$event_function['bezeichnung'],
				$value['nummer'],
				$eventday_data,
				$value['aktSumme'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		//if(!in_array('createEventuser', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		$this->form_validation->set_rules('eventuser', 'Festmitarbeiter', 'trim|integer|greater_than[0]');
		$this->form_validation->set_rules('eventfunction', 'Festfunktion', 'trim|integer');
		$this->form_validation->set_rules('number', 'Mitarbeiternummer', 'trim|integer');
		$this->form_validation->set_rules('eventday', 'Festtag', 'trim|integer');
		//$this->form_validation->set_rules('status', 'Status', 'trim');

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() == true) {
			if (empty($this->input->post('number'))) {
				
				
				$number = $this->model_eventuser->getNextFreeNumber($this->input->post('eventday'));
				//print_r($this->model_eventuser->getNextFreeNumber($this->input->post('eventday')));


			} else {
				$number = $this->input->post('number');
			}



			$data = array(
				'idMitarbeiter' => $this->input->post('eventuser'),
				'idFestfunktion' => $this->input->post('eventfunction'),
				'nummer' => $number,
				'idFesttag' => $this->input->post('eventday'),
				'status' => 1,
			);
			
			$create = $this->model_eventuser->create($data);
			if ($create == true) {
				$response['success'] = true;
				$response['messages'] = 'Festmitarbeiter erfolgreich angelegt';
			} else {
				$response['success'] = false;
				$response['messages'] = 'Beim Anlegen des Festmitarbeiter ist ein Fehler in der Datenbank aufgetreten';
			}
		} else {
			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($response);
	}

	public function fetchDataById($id = null)
	{
		if ($id) {
			$data = $this->model_eventuser->getData($id);
			echo json_encode($data);
		}
	}

	//Festmitarbeiter anhand der Kellnernummer ermitteln -> POS
	public function fetchDataByNumber($number = null)
	{
		if ($number) {
			$data = $this->model_eventuser->getIdByNumber($number, $this->session->userdata('eventday'));
			echo json_encode($data);
		}
	}


	public function getActiveData()
	{
		$data = $this->model_eventuser->getInServiceComplete($this->session->userdata('eventday'));
		echo json_encode($data);
	}

	public function getRemainingUser()
	{
		$data = $this->model_eventuser->getRemainingUser($this->session->userdata('eventday'));
		echo json_encode($data);
	}



	public function update($id)
	{
		//if(!in_array('updateEventarticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		if ($id) {

			//$this->form_validation->set_rules('edit_user', 'Festmitarbeiter', 'trim|integer');
			$this->form_validation->set_rules('edit_eventfunction', 'Festfunktion', 'trim|integer');
			$this->form_validation->set_rules('edit_number', 'Mitarbeiternummer', 'trim|integer');
			//$this->form_validation->set_rules('edit_eventday', 'Festtag', 'trim|integer');
			//$this->form_validation->set_rules('edit_status', 'Status', 'trim');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() == true) {
				if (empty($this->input->post('edit_number'))) {
					$number = null;
				} else {
					$number = $this->input->post('edit_number');
				}

				$data = array(
					//'idMitarbeiter' => $this->input->post('edit_user'),
					'idFestfunktion' => $this->input->post('edit_eventfunction'),
					'nummer' => $number,
					//'idFesttag' => $this->input->post('edit_eventday'),	
					//'status' => $this->input->post('edit_status'),	
				);

				$update = $this->model_eventuser->update($id, $data);
				if ($update == true) {
					$response['success'] = true;
					$response['messages'] = 'Festmitarbeiter erfolgreich gespeichert';
				} else {
					$response['success'] = false;
					$response['messages'] = 'Beim Speichern des Festmitarbeiter ist ein Fehler in der Datenbank aufgetreten';
				}
			} else {
				$response['success'] = false;
				foreach ($_POST as $key => $value) {
					$response['messages'][$key] = form_error($key);
				}
			}
		} else {
			$response['success'] = false;
			$response['messages'] = 'Fehler!! Bitte die Seite neu laden!!';
		}

		echo json_encode($response);
	}

	//Festmitarbeiter in Dienst stellen
	public function startservice($id)
	{

		$response = array();

		if ($id) {

			$eventuser_data = $this->model_eventuser->getData($id);
			$user_data = $this->model_users->getUserData($eventuser_data['idMitarbeiter']);

			$this->form_validation->set_rules('activate_money', 'Wechselgeld', 'decimal');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


			if ($this->form_validation->run() == true) {

				$data = array(
					'aktSumme' => $this->input->post('activate_money'),
					'status' => 2,
				);

				$dataCB = array(
					'vorgang' => 1,
					'buchungstext' => 'Festmitarbeiter ' . $user_data['name'] . " " . $user_data['vorname'] . ' in Dienst gesetzt',
					'idFesttag' => $eventuser_data['idFesttag'],
					'idPerson' => $eventuser_data['idMitarbeiter'],
					'buchungstyp' => 2,
					'summe' => ($this->input->post('activate_money')) * -1,
				);

				$cashbookentry = $this->model_cashbook->create($dataCB);
				$update = $this->model_eventuser->service($id, $data);
				if ($update == true) {
					$response['success'] = true;
					$response['messages'] = 'Festmitarbeiter in Dienst gesetzt';
				} else {
					$response['success'] = false;
					$response['messages'] = 'Beim in Dienst setzen des Festmitarbeiter ist ein Fehler in der Datenbank aufgetreten';
				}
			} else {
				$response['success'] = false;
				$response['messages'] = 'Fehler!! Bitte die Seite neu laden!!';
			}

			echo json_encode($response);
		}
	}

	//Festmitarbeiter abrechnen
	public function cashupservice($id)
	{

		$response = array();

		if ($id) {

			$eventuser_data = $this->model_eventuser->getData($id);
			$user_data = $this->model_users->getUserData($eventuser_data['idMitarbeiter']);

			//$this->form_validation->set_rules('activate_money', 'Wechselgeld', 'decimal');

			//$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			//if ($this->form_validation->run() == TRUE) {

			if ($this->input->post('cashup_money') < $eventuser_data['aktSumme']) {
				$entry_summe = $eventuser_data['aktSumme'] - $this->input->post('cashup_money');

				$data = array(
					'aktSumme' => $entry_summe,
					//'status' => 3,
				);

				$dataCB = array(
					'vorgang' => 2,
					'buchungstext' => 'Festmitarbeiter ' . $user_data['name'] . " " . $user_data['vorname'] . ' zwischengerechnet',
					'idFesttag' => $eventuser_data['idFesttag'],
					'idPerson' => $eventuser_data['idMitarbeiter'],
					'buchungstyp' => 2,
					'summe' => $this->input->post('cashup_money'),
				);
			} elseif ($this->input->post('cashup_money') == $eventuser_data['aktSumme']) {
				$data = array(
					'aktSumme' => 0.0,
					'status' => 3,
				);

				$dataCB = array(
					'vorgang' => 2,
					'buchungstext' => 'Festmitarbeiter ' . $user_data['name'] . " " . $user_data['vorname'] . ' abgerechnet',
					'idFesttag' => $eventuser_data['idFesttag'],
					'idPerson' => $eventuser_data['idMitarbeiter'],
					'buchungstyp' => 2,
					'summe' => $this->input->post('cashup_money'),
				);
			}


			$cashbookentry = $this->model_cashbook->create($dataCB);
			$update = $this->model_eventuser->service($id, $data);
			if (($update == true) && ($cashbookentry == true)) {
				$response['success'] = true;
				$response['messages'] = 'Festmitarbeiter abgerechnet';
			} else {
				$response['success'] = false;
				$response['messages'] = 'Beim Abrechnen des Festmitarbeiter ist ein Fehler in der Datenbank aufgetreten';
			}
		} else {
			$response['success'] = false;
			$response['messages'] = 'Fehler!! Bitte die Seite neu laden!!';
		}

		echo json_encode($response);
	}


	//Festmitarbeiter wieder in Dienst stellen
	public function undoservice($id)
	{

		$response = array();

		if ($id) {

			$eventuser_data = $this->model_eventuser->getData($id);
			$user_data = $this->model_users->getUserData($eventuser_data['idMitarbeiter']);

			$this->form_validation->set_rules('undo_money', 'Wechselgeld', 'decimal');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() == true) {

				$data = array(
					'aktSumme' => $this->input->post('undo_money'),
					'status' => 2,
				);

				$dataCB = array(
					'vorgang' => 1,
					'buchungstext' => 'Festmitarbeiter ' . $user_data['name'] . " " . $user_data['vorname'] . ' wieder in Dienst gesetzt',
					'idFesttag' => $eventuser_data['idFesttag'],
					'idPerson' => $eventuser_data['idMitarbeiter'],
					'buchungstyp' => 2,
					'summe' => ($this->input->post('undo_money')) * -1,
				);

				$cashbookentry = $this->model_cashbook->create($dataCB);
				$update = $this->model_eventuser->service($id, $data);
				if ($update == true) {
					$response['success'] = true;
					$response['messages'] = 'Festmitarbeiter wieder in Dienst gesetzt';
				} else {
					$response['success'] = false;
					$response['messages'] = 'Beim in Dienst setzen des Festmitarbeiter ist ein Fehler in der Datenbank aufgetreten';
				}
			} else {
				$response['success'] = false;
				$response['messages'] = 'Fehler!! Bitte die Seite neu laden!!';
			}

			echo json_encode($response);
		}
	}

	public function remove()
	{
		//if(!in_array('deleteEventarticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$eventuser_id = $this->input->post('eventuser_id');

		$response = array();
		if ($eventuser_id) {
			$delete = $this->model_eventuser->remove($eventuser_id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Festmitarbeiter erfolgreich gelöscht";
			} else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen des Festmitarbeiter ist ein Fehler in der Datenbank aufgetreten";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}
}
