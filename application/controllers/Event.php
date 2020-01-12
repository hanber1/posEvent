<?php 

class Event extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Fest';
		$this->load->model('model_event');
		$this->load->model('model_eventtype');
	}

	public function index()
	{	
		$eventtype_data = $this->model_eventtype->getActive();
		$this->data['eventtype_data'] = $eventtype_data;
		$this->render_template('event/index', $this->data);
	}

	public function fetchData()
	{
		//if(!in_array('viewEvent', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$result = array('data' => array());

		$data = $this->model_event->getData();

		foreach ($data as $key => $value) {

			$eventtype_data = $this->model_eventtype->getData($value['idFesttyp']);

			// button
			$buttons = '';

			if(in_array('updateEvent', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteEvent', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			$result['data'][$key] = array(
				$value['bezeichnung'],
				$value['zeitraum'],
				$eventtype_data['bezeichnung'],
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

		$this->form_validation->set_rules('event_name', 'Festname', 'trim|required');
		$this->form_validation->set_rules('daterange', 'Zeitraum', 'trim');
		$this->form_validation->set_rules('eventtype', 'Festtyp', 'trim|integer');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'bezeichnung' => $this->input->post('event_name'),
        		'zeitraum' => $this->input->post('daterange'),	
        		'idFesttyp' => $this->input->post('eventtype'),	
        	);

        	$create = $this->model_event->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Fest erfolgreich angelegt';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Beim Anlegen des Festes ist ein Fehler in der Datenbank aufgetreten';			
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
			$data = $this->model_event->getData($id);
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
			$this->form_validation->set_rules('edit_event_name', 'Festname', 'trim|required');
			$this->form_validation->set_rules('edit_daterange', 'Zeitraum', 'trim');
			$this->form_validation->set_rules('edit_eventtype', 'Festtyp', 'trim|required');
	
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'bezeichnung' => $this->input->post('edit_event_name'),
        			'zeitraum' => $this->input->post('edit_daterange'),	
        			'idFesttyp' => $this->input->post('edit_eventtype'),	
	        	);

	        	$update = $this->model_event->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Fest erfolgreich gespeichert';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Beim Speichern des Festes ist ein Fehler in der Datenbank aufgetreten';			
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
		
		$event_id = $this->input->post('event_id');

		$response = array();
		if($event_id) {
			$delete = $this->model_event->remove($event_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Fest erfolgreich gelöscht";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen des Festes ist ein Fehler in der Datenbank aufgetreten";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

}