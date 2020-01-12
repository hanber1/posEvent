<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
		$this->load->model('model_eventday');

		$eventday = $this->model_eventday->getActiveEvent();
		$this->data['eventday_data'] = $eventday;

	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/

	public function login()
	{


		$this->logged_in();


		$this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$email_exists = $this->model_auth->check_email($this->input->post('email'));

           	if($email_exists == TRUE) {
           		$login = $this->model_auth->login($this->input->post('email'), $this->input->post('password'));

           		if($login) {
					if ($login['id'] == 1) {
						$logged_in_sess = array(
							'id' => $login['id'],
						 'email'     => $login['email'],
						 'logged_in' => TRUE

						);
						$this->session->set_userdata($logged_in_sess);
						redirect('dashboard', 'refresh');

					 } else {
						 if ($this->input->post('eventday') == 0) {
							$this->data['errors'] = 'Fehlender Festtag';
							$this->load->view('login', $this->data);
							  } else {
								$logged_in_sess = array(
									'id' => $login['id'],
									 'eventday'  => $this->input->post('eventday'),
									 'email'     => $login['email'],
									 'logged_in' => TRUE
		
								);
		
								 $this->session->set_userdata($logged_in_sess);
								 redirect('dashboard', 'refresh');
		
							  }
 
					 }

					if ($login['id'] == 1) {
						$this->session->set_userdata($logged_in_sess);
						redirect('dashboard', 'refresh');
					 } else {
					}
					
           		}
           		else {
           			$this->data['errors'] = 'Falsche E-Mail/Passwort Kombination';
           			$this->load->view('login', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'Die E-mail existiert leider nicht';

           		$this->load->view('login', $this->data);
           	}	
        }
        else {
            // false case
            $this->load->view('login', $this->data);
        }	
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}

}
