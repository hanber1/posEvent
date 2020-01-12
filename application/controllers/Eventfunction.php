<?php 

class Eventfunction extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Festfunktion';
		$this->load->model('model_eventfunction');
	}

	public function index()
	{
		$this->render_template('eventfunction/index', $this->data);
	}

	public function fetchData()
	{
		$result = array('data' => array());

		$data = $this->model_eventfunction->getData();

		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if(in_array('updateEventfunction', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteEventfunction', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['status'] == 1) ? '<span class="label label-success">Aktiv</span>' : '<span class="label label-warning">Inaktiv</span>';

			$result['data'][$key] = array(
				$value['bezeichnung'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		// if(!in_array('createEventfunction', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		$this->form_validation->set_rules('eventfunction_name', 'Festfunktion', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'bezeichnung' => $this->input->post('eventfunction_name'),
        		'status' => $this->input->post('status'),	
        	);

        	$create = $this->model_eventfunction->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Festfunktion erfolgreich angelegt';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Beim Anlegen der Festfunktion ist ein Fehler in der Datenbank aufgetreten';			
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
			$data = $this->model_eventfunction->getData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		// if(!in_array('updateEventfunction', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_eventfunction_name', 'Festfunktion', 'trim|required');
			$this->form_validation->set_rules('edit_status', 'Status', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'bezeichnung' => $this->input->post('edit_eventfunction_name'),
        			'status' => $this->input->post('edit_status'),	
	        	);

	        	$update = $this->model_eventfunction->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Festfunktion erfolgreich gespeichert';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Beim Speichern der Festfunktion ist ein Fehler in der Datenbank aufgetreten';			
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
		if(!in_array('deleteEventfunction', $this->permission)) {
		 	redirect('dashboard', 'refresh');
		 }
		
		$eventfunction_id = $this->input->post('eventfunction_id');

		$response = array();
		if($eventfunction_id) {
			$delete = $this->model_eventfunction->remove($eventfunction_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Festfunktion erfolgreich gelöscht";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen der Festfunktion ist ein Fehler in der Datenbank aufgetreten";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

}