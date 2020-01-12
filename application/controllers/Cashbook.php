<?php 

class Cashbook extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Kassabuch';
		$this->load->model('model_cashbook');
		// $this->load->model('model_eventuser');
		// $this->load->model('model_eventfunction');
		$this->load->model('model_users');
		// $this->load->model('model_event');
		$this->load->model('model_eventday');
	}

	public function index()
	{	
		$cashbook = $this->model_cashbook->getData();
		$this->data['cashbook'] = $cashbook;


		// $user = $this->model_users->getUserData($cashbook['createdBy']);
		// $this->data['created'] = $user;
		// $countActEventUser = $this->model_eventuser->countActive();
		// $this->data['countActEvUs'] = $countActEventUser;	
		if ($this->session->userdata('id') == 1) {
			$eventdayEvent = $this->model_eventday->getActiveEvent();
			$this->data['eventdayEvent'] = $eventdayEvent;
		} else {
			$eventdayEvent = $this->model_eventday->getActiveEvent($this->session->userdata('eventday'));
			$this->data['eventdayEvent'] = $eventdayEvent;
		}
		// $eventfunction = $this->model_eventfunction->getActive();
		// $this->data['eventfunction'] = $eventfunction;
		//$category_data = $this->model_category->getActive();
		//$this->data['category_data'] = $category_data;
		//$unit_data = $this->model_unit->getActive();
		//$this->data['unit_data'] = $unit_data;
		$this->render_template('cashbook/index', $this->data);
	}

	public function fetchData()
	{
		//if(!in_array('viewEventuser', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$result = array('data' => array());

		//$data = $this->model_cashbook->getData();

		if ($this->session->userdata('id') == 1) {
			$data = $this->model_cashbook->getData();
		} else {
			$data = $this->model_cashbook->getDataEventday($this->session->userdata('eventday'));
		}


		foreach ($data as $key => $value) {

			$user_data = $this->model_users->getUserData($value['createdBy']);
			//$eventday_data = $this->model_eventuser->getEventdayEventData($value['idFesttag']);
			//$event_function = $this->model_eventfunction->getData($value['idFestfunktion']);

			// button
			$buttons = '';

			if(in_array('updateCashbook', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteCashbook', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			if ($value['vorgang'] == 1) {
				$status = '<span class="label label-danger">Ausgang</span>';
			} elseif ($value['vorgang'] == 2) {
				$status = '<span class="label label-success">Eingang</span>';
			}	
			{
				# code...
			}
			
			$result['data'][$key] = array(
				// $event_function['bezeichnung'],
				$value['created'],
				$value['buchungstext'],
				// $eventday_data,
				$value['summe'],
				$status,
				$user_data['name'] ." ". $user_data['vorname'],
				$buttons,
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

		$this->form_validation->set_rules('cashtext', 'Buchungstext', 'trim|required');
		$this->form_validation->set_rules('cash', 'Summe', 'decimal');
		$this->form_validation->set_rules('eventday', 'Festtag', 'trim');
		$this->form_validation->set_rules('process', 'Vorgang', 'trim');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {

			$process = $this->input->post('process');

			if ($process == 1) {
				$summe = ($this->input->post('cash'))*-1;
			}
			elseif ($process == 2) {
				$summe = $this->input->post('cash');
			} 

			$data = array(
        		'vorgang' => $this->input->post('process'),	
        		'buchungstext' => $this->input->post('cashtext'),
        		'idFesttag' => $this->input->post('eventday'),
        		'idPerson' => $this->session->userdata('id'),
        		'buchungstyp' => 1,
				'summe' => $summe,
        	);

        	$create = $this->model_cashbook->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Kassaeintrag erfolgreich angelegt';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Beim Anlegen des Kassaeintrages ist ein Fehler in der Datenbank aufgetreten';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	public function fetchDataById($id = null)
	{
		if($id) {
			$data = $this->model_cashbook->getData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		//if(!in_array('updateEventarticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		if($id) {

			$this->form_validation->set_rules('edit_cashtext', 'Buchungstext', 'trim|required');
			// $this->form_validation->set_rules('edit_cash', 'Summe', 'decimal');
			// $this->form_validation->set_rules('edit_process', 'Vorgang', 'trim');
		
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
	
			if ($this->form_validation->run() == TRUE) {
				
				$data = array(
					// 'vorgang' => $this->input->post('edit_process'),	
					'buchungstext' => $this->input->post('edit_cashtext'),
					// 'summe' => $summe,
				);

	        	$update = $this->model_cashbook->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Buchungstext erfolgreich gespeichert';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Beim Speichern des Buchungstextes ist ein Fehler in der Datenbank aufgetreten';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Fehler!! Bitte die Seite neu laden!!';
		}

		echo json_encode($response);
	}

	public function remove()
	{
		//if(!in_array('deleteEventarticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$cashbook_id = $this->input->post('cashbook_id');

		$response = array();
		if($cashbook_id) {
			$delete = $this->model_cashbook->remove($cashbook_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Buchungszeile erfolgreich gelöscht";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen der Buchungszeile ist ein Fehler in der Datenbank aufgetreten";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

}