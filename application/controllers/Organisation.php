<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Organisation extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Organisation';

		$this->load->model('model_organisation');
	}

    /* 
    * It redirects to the company page and displays all the company information
    * It also updates the company information into the database if the 
    * validation for each input field is successfully valid
    */
	public function index()
	{  
        if(!in_array('updateOrganisation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$this->form_validation->set_rules('organisation_name', 'Organisationsname', 'trim|required');
		$this->form_validation->set_rules('address', 'Addresse', 'trim');
		$this->form_validation->set_rules('email', 'E-Mail', 'trim');
		$this->form_validation->set_rules('message', 'Beschreibung', 'trim');
	
	
        if ($this->form_validation->run() == TRUE) {
            // true case

        	$data = array(
        		'name' => $this->input->post('organisation_name'),
        		'addresse' => $this->input->post('address'),
        		'telefon' => $this->input->post('phone'),
        		'email' => $this->input->post('email'),
        		'beschreibung' => $this->input->post('message'),
                'waehrung' => $this->input->post('currency')
        	);

        	$update = $this->model_organisation->update($data, 1);
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Organisation erfolgreich gespeichert');
        		redirect('organisation/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Beim Speichern der Organisation ist ein Fehler in der Datenbank aufgetreten');
        		redirect('organisation/index', 'refresh');
        	}
        }
        else {

            // false case
            $this->data['currency_symbols'] = $this->currency();
        	$this->data['organisation_data'] = $this->model_organisation->getData(1);
			$this->render_template('organisation/index', $this->data);			
        }	

		
	}

}