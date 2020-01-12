<?php 

class Cashregister extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Kassa';
		$this->load->model('model_cashregister');
	}

	public function index()
	{
		$this->render_template('cashregister/index', $this->data);
	}

	public function fetchData()
	{
		$result = array('data' => array());

		$data = $this->model_cashregister->getData();

		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if(in_array('updateCashregister', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteCashregister', $this->permission)) {
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
		// if(!in_array('createCashregister', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		$this->form_validation->set_rules('cashregister_name', 'Kassa', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'bezeichnung' => $this->input->post('cashregister_name'),
        		'status' => $this->input->post('status'),	
        	);

        	$create = $this->model_cashregister->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Kassa erfolgreich angelegt';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Beim Anlegen der Kassa ist ein Fehler in der Datenbank aufgetreten';			
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
			$data = $this->model_cashregister->getData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		// if(!in_array('updateCashregister', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_cashregister_name', 'Kassa', 'trim|required');
			$this->form_validation->set_rules('edit_status', 'Status', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'bezeichnung' => $this->input->post('edit_cashregister_name'),
        			'status' => $this->input->post('edit_status'),	
	        	);

	        	$update = $this->model_cashregister->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Kassa erfolgreich gespeichert';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Beim Speichern der Kassa ist ein Fehler in der Datenbank aufgetreten';			
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
		// if(!in_array('deleteCashregister', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }
		
		$cashregister_id = $this->input->post('cashregister_id');

		$response = array();
		if($cashregister_id) {
			$delete = $this->model_cashregister->remove($cashregister_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Kassa erfolgreich gelöscht";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen der Kassa ist ein Fehler in der Datenbank aufgetreten";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

}