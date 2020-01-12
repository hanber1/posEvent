<?php 

class Eventday extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Festtag';
		$this->load->model('model_eventday');
		$this->load->model('model_event');
	}

	public function index()
	{	
		$event_data = $this->model_event->getData();
		$this->data['event_data'] = $event_data;
		$this->render_template('eventday/index', $this->data);
	}

	public function fetchData()
	{
		//if(!in_array('viewEvent', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$result = array('data' => array());

		$data = $this->model_eventday->getData();

		foreach ($data as $key => $value) {

			$event_data = $this->model_event->getData($value['idFest']);

			// button
			$buttons = '';

			if(in_array('updateEventday', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteEventday', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['status'] == 1) ? '<span class="label label-success">Aktiv</span>' : '<span class="label label-warning">Inaktiv</span>';

			$result['data'][$key] = array(
				$event_data['bezeichnung'],
				$value['bezeichnung'],
				$value['datum'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		//if(!in_array('createEvent', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		$this->form_validation->set_rules('eventday_name', 'Festtagname', 'trim|required');
		$this->form_validation->set_rules('date', 'Datum', 'trim');
		$this->form_validation->set_rules('event', 'Fest', 'trim|integer');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'bezeichnung' => $this->input->post('eventday_name'),
        		'datum' => $this->input->post('date'),	
        		'idFest' => $this->input->post('event'),	
        		'status' => $this->input->post('status'),	
        	);

        	$create = $this->model_eventday->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Festtag erfolgreich angelegt';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Beim Anlegen des Festtages ist ein Fehler in der Datenbank aufgetreten';			
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
			$data = $this->model_eventday->getData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		//if(!in_array('updateEvent', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_eventday_name', 'Festtagname', 'trim|required');
			$this->form_validation->set_rules('edit_date', 'Datum', 'trim');
			$this->form_validation->set_rules('edit_event', 'Fest', 'trim|required');
			$this->form_validation->set_rules('edit_status', 'Status', 'trim|integer');
	
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'bezeichnung' => $this->input->post('edit_eventday_name'),
        			'datum' => $this->input->post('edit_date'),	
        			'idFest' => $this->input->post('edit_event'),	
					'status' => $this->input->post('edit_status'),	
	        	);

	        	$update = $this->model_eventday->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Festtag erfolgreich gespeichert';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Beim Speichern des Festtages ist ein Fehler in der Datenbank aufgetreten';			
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
		//if(!in_array('deleteEvent', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$eventday_id = $this->input->post('eventday_id');

		$response = array();
		if($eventday_id) {
			$delete = $this->model_eventday->remove($eventday_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Festtag erfolgreich gelöscht";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen des Festtages ist ein Fehler in der Datenbank aufgetreten";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

}