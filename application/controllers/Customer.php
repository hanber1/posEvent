<?php 

class Customer extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Kunden';
		$this->load->model('model_customer');
	}

	public function index()
	{
		$this->render_template('customer/index', $this->data);
	}

	public function fetchData()
	{
		$result = array('data' => array());

		$data = $this->model_customer->getData();

		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if(in_array('updateCustomer', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteCustomer', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['status'] == 1) ? '<span class="label label-success">Aktiv</span>' : '<span class="label label-warning">Inaktiv</span>';

			$result['data'][$key] = array(
				$value['name'],
				$value['adresse'],
				$value['telefon'],
				$value['email'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		// if(!in_array('createCustomer', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		$this->form_validation->set_rules('name', 'Kundenname', 'trim|required');
		$this->form_validation->set_rules('first_name', 'Vorname', 'trim');
		$this->form_validation->set_rules('phone', 'Telefonnummer', 'trim');
		$this->form_validation->set_rules('email', 'E-Mailadresse', 'trim');
		$this->form_validation->set_rules('adress', 'Adresse', 'trim');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('name'),
        		'vorname' => $this->input->post('first_name'),
        		'telefon' => $this->input->post('phone'),
        		'email' => $this->input->post('email'),
        		'adresse' => $this->input->post('adress'),
        		'status' => $this->input->post('status'),	
        	);

        	$create = $this->model_customer->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Kunde erfolgreich angelegt';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Beim Anlegen des Kunden ist ein Fehler in der Datenbank aufgetreten';			
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
			$data = $this->model_customer->getData($id);
			echo json_encode($data);
		}
		
	}

	public function getActiveData()
	{
			$data = $this->model_customer->getActive();
			echo json_encode($data);
		
	}

	public function update($id)
	{
		// if(!in_array('updateUnit', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_name', 'Kundenname', 'trim|required');
			$this->form_validation->set_rules('edit_first_name', 'Vorname', 'trim');
			$this->form_validation->set_rules('edit_phone', 'Telefonnummer', 'trim');
			$this->form_validation->set_rules('edit_email', 'E-Mailadresse', 'trim');
			$this->form_validation->set_rules('edit_adress', 'Adresse', 'trim');
			$this->form_validation->set_rules('edit_status', 'Status', 'trim|required');
	
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
					'name' => $this->input->post('edit_name'),
					'vorname' => $this->input->post('edit_first_name'),
					'telefon' => $this->input->post('edit_phone'),
					'email' => $this->input->post('edit_email'),
					'adresse' => $this->input->post('edit_adress'),
					'status' => $this->input->post('edit_status'),	
					);

	        	$update = $this->model_customer->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Kunde erfolgreich gespeichert';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Beim Speichern des Kunden ist ein Fehler in der Datenbank aufgetreten';			
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
		// if(!in_array('deleteUnit', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }
		
		$customer_id = $this->input->post('customer_id');

		$response = array();
		if($customer_id) {
			$delete = $this->model_customer->remove($customer_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Kunde erfolgreich gelöscht";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen des Kunden ist ein Fehler in der Datenbank aufgetreten";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

}