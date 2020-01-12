<?php 

class Eventcashregister extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Festkassa';
		$this->load->model('model_eventcashregister');
		$this->load->model('model_cashregister');
		$this->load->model('model_cashbook');
		$this->load->model('model_eventday');
	}

	public function index()
	{
		$cashregister = $this->model_cashregister->getActive();
		$this->data['cashregister'] = $cashregister;
		$countActEventCashregister = $this->model_eventcashregister->countActive();
		$this->data['countActEvCash'] = $countActEventCashregister;
		if ($this->session->userdata('id') == 1) {
			$eventdayEvent = $this->model_eventday->getActiveEvent();
			$this->data['eventdayEvent'] = $eventdayEvent;
		} else {
			$eventdayEvent = $this->model_eventday->getActiveEvent($this->session->userdata('eventday'));
			$this->data['eventdayEvent'] = $eventdayEvent;
		}
		$this->render_template('eventcashregister/index', $this->data);
	}

	public function fetchData()
	{
		//if(!in_array('viewEventcashregister', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$result = array('data' => array());

		if ($this->session->userdata('id') == 1) {
			$data = $this->model_eventcashregister->getData();
		} else {
			$data = $this->model_eventcashregister->getDataEventday($this->session->userdata('eventday'));
		}

		foreach ($data as $key => $value) {

			$cashregister_data = $this->model_cashregister->getData($value['idKassa']);
			$eventday_data = $this->model_eventday->getEventdayEventData($value['idFesttag']);

			// button
			$buttons = '';

			// if(in_array('updateEventcashregister', $this->permission) && ($cashregister_data['status'] == 1)) {
			// 	$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			// }

			if (in_array('deleteEventcashregister', $this->permission) && ($cashregister_data['status'] == 1)) {
				$buttons = ' <button type="button" class="btn btn-danger" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			if ( ($value['status'] == 1) && ($cashregister_data['status'] == 1)) {
				$buttons .= ' <button type="button" class="btn btn-success" onclick="activateFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#activateModal" title="In Dienst setzen"><i class="fa fa-sign-out"></i></button>';
			}

			if ( ($value['status'] == 2) && ($cashregister_data['status'] == 1)) {
				$buttons .= ' <button type="button" class="btn btn-info" onclick="cashupFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#cashupModal" title="Abrechnen"><i class="fa fa-sign-in"></i></button>';
			}

			if ( ($value['status'] == 3) && ($cashregister_data['status'] == 1)) {
				$buttons .= ' <button type="button" class="btn btn-warning" onclick="undoFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#undoModal" title="Wieder aktivieren"><i class="fa fa-undo"></i></button>';
			}

			if ($value['status'] == 1) {
				$status = '<span class="label label-warning">Ausser Dienst</span>';
			} elseif ($value['status'] == 2) {
				$status = '<span class="label label-success">In Dienst</span>';
			} elseif ($value['status'] == 3) {
				$status = '<span class="label label-primary">Abgerechnet</span>';
			}
			{
				# code...
			}

			$result['data'][$key] = array(
				$cashregister_data['bezeichnung'],
				$eventday_data,
				$value['aktSumme'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function fetchDataById($id = null)
	{
		if ($id) {
			$data = $this->model_eventcashregister->getData($id);
			echo json_encode($data);
		}
	}

	public function getActiveData()
	{
		$data = $this->model_eventcashregister->getInServiceComplete($this->session->userdata('eventday'));
		echo json_encode($data);
	}

	public function getRemainingCashregister()
	{
		$data = $this->model_eventcashregister->getRemainingCashregister($this->session->userdata('eventday'));
		echo json_encode($data);
	}

	public function create()
	{
		//if(!in_array('createEventcashregister', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		$this->form_validation->set_rules('eventcashregister', 'Festkassa', 'trim|integer|greater_than[0]');
		$this->form_validation->set_rules('eventday', 'Festtag', 'trim|integer');

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() == true) {
			if (empty($this->input->post('number'))) {
				$number = null;
			} else {
				$number = $this->input->post('number');
			}

			$data = array(
				'idKassa' => $this->input->post('eventcashregister'),
				'idFesttag' => $this->input->post('eventday'),
				'status' => 1, //Status nicht in Dienst setzen	
			);

			$create = $this->model_eventcashregister->create($data);
			if ($create == true) {
				$response['success'] = true;
				$response['messages'] = 'Festkassa erfolgreich angelegt';
			} else {
				$response['success'] = false;
				$response['messages'] = 'Beim Anlegen der Festkassa ist ein Fehler in der Datenbank aufgetreten';
			}
		} else {
			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($response);
	}

	//Festkassa in Dienst stellen
	public function startservice($id)
	{

		$response = array();

		if ($id) {

			$eventcashregister_data = $this->model_eventcashregister->getData($id);
			$cashregister_data = $this->model_cashregister->getData($eventcashregister_data['idKassa']);

			$this->form_validation->set_rules('activate_money', 'Wechselgeld', 'decimal');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


			if ($this->form_validation->run() == true) {

				$data = array(
					'aktSumme' => $this->input->post('activate_money'), //Wechselgeld auf Aktive Summe schreiben
					'status' => 2, //Status in Dienst setzen
				);

				// Daten in Kassabuch eintragen		
				$dataCB = array(
					'vorgang' => 1, //Auszahlung
					'buchungstext' => 'Festkassa ' . $cashregister_data['bezeichnung'] . ' in Dienst gesetzt',
					'idFesttag' => $eventcashregister_data['idFesttag'],
					'idPerson' => $eventcashregister_data['idKassa'],
					'buchungstyp' => 3, //Kassa
					'summe' => ($this->input->post('activate_money')) * -1, //als Minusbetrag eintragen
				);

				$cashbookentry = $this->model_cashbook->create($dataCB);
				$update = $this->model_eventcashregister->service($id, $data);
				if (($update == true) && ($cashbookentry == true)) {
					$response['success'] = true;
					$response['messages'] = 'Festkassa in Dienst gesetzt';
				} else {
					$response['success'] = false;
					$response['messages'] = 'Beim in Dienst setzen der Festkassa ist ein Fehler in der Datenbank aufgetreten';
				}
			} else {
				$response['success'] = false;
				$response['messages'] = 'Fehler!! Bitte die Seite neu laden!!';
			}

			echo json_encode($response);
		}
	}

	//Festkassa abrechnen
	public function cashupservice($id)
	{

		$response = array();

		if ($id) {

			$eventcashregister_data = $this->model_eventcashregister->getData($id);
			$cashregister_data = $this->model_cashregister->getData($eventcashregister_data['idKassa']);


			if ($this->input->post('cashup_status') == 1) {
				// Zwischenrechnen

				$data = array(
					//'aktSumme' => $entry_summe,
					//'status' => 3,
				);

				$dataCB = array(
					'vorgang' => 2,
					'buchungstext' => 'Festkassa ' . $cashregister_data['bezeichnung'] . ' zwischengerechnet',
					'idFesttag' => $eventcashregister_data['idFesttag'],
					'idPerson' => $eventcashregister_data['idKassa'],
					'buchungstyp' => 3, //Kassa
					'summe' => $this->input->post('cashup_money'),
				);
			}
			// Abrechnen
			elseif ($this->input->post('cashup_status') == 2) {
				$data = array(
					'aktSumme' => 0.0,
					'status' => 3,
				);

				$dataCB = array(
					'vorgang' => 2,
					'buchungstext' => 'Festkassa ' . $cashregister_data['bezeichnung'] . ' abgerechnet',
					'idFesttag' => $eventcashregister_data['idFesttag'],
					'idPerson' => $eventcashregister_data['idKassa'],
					'buchungstyp' => 3, //Kassa
					'summe' => $this->input->post('cashup_money'),
				);
			}


			$cashbookentry = $this->model_cashbook->create($dataCB);
			$update = $this->model_eventcashregister->service($id, $data);
			if (($update == true) && ($cashbookentry == true)) {
				$response['success'] = true;
				$response['messages'] = 'Festkassa zwischen/abgerechnet';
			} else {
				$response['success'] = false;
				$response['messages'] = 'Beim Abrechnen der Festkassa ist ein Fehler in der Datenbank aufgetreten';
			}
		} else {
			$response['success'] = false;
			$response['messages'] = 'Fehler!! Bitte die Seite neu laden!!';
		}

		echo json_encode($response);
	}


	//Festkassa wieder in Dienst stellen
	public function undoservice($id)
	{

		$response = array();

		if ($id) {

			$eventcashregister_data = $this->model_eventcashregister->getData($id);
			$cashregister_data = $this->model_cashregister->getData($eventcashregister_data['idKassa']);

			$this->form_validation->set_rules('undo_money', 'Wechselgeld', 'decimal');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() == true) {

				$data = array(
					'aktSumme' => $this->input->post('undo_money'),
					'status' => 2,
				);

				$dataCB = array(
					'vorgang' => 1, //Auszahlung
					'buchungstext' => 'Festkassa ' . $cashregister_data['bezeichnung'] . ' wieder in Dienst gesetzt',
					'idFesttag' => $eventcashregister_data['idFesttag'],
					'idPerson' => $eventcashregister_data['idKassa'],
					'buchungstyp' => 3, //Kassa
					'summe' => ($this->input->post('undo_money')) * -1, //als Minusbetrag eintragen
				);

				$cashbookentry = $this->model_cashbook->create($dataCB);
				$update = $this->model_eventcashregister->service($id, $data);
				if (($update == true) && ($cashbookentry == true)) {
					$response['success'] = true;
					$response['messages'] = 'Festkassa wieder in Dienst gesetzt';
				} else {
					$response['success'] = false;
					$response['messages'] = 'Beim in Dienst setzen der Festkassa ist ein Fehler in der Datenbank aufgetreten';
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
		//if(!in_array('deleteEventcashregister', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$eventcashregister_id = $this->input->post('eventcashregister_id');

		$response = array();
		if ($eventcashregister_id) {
			$delete = $this->model_eventcashregister->remove($eventcashregister_id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Festkassa erfolgreich gelöscht";
			} else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen der Festkassa ist ein Fehler in der Datenbank aufgetreten";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}
}

