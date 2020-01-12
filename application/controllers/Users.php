<?php 

class Users extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Mitarbeiter';


		$this->load->model('model_users');
		$this->load->model('model_groups');
		//$this->load->model('model_stores');
	}

	public function index()
	{

		if (!in_array('viewUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_data = $this->model_users->getUserData();

		$result = array();
		foreach ($user_data as $k => $v) {

			$result[$k]['user_info'] = $v;

			$group = $this->model_users->getUserGroup($v['id']);
			$result[$k]['user_group'] = $group;
		}

		$this->data['user_data'] = $result;

		$this->render_template('users/index', $this->data);
	}

	public function create()
	{

		if (!in_array('createUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		//$this->form_validation->set_rules('firstname', 'Vorname', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Nachname', 'trim|required');
		$this->form_validation->set_rules('email', 'E-Mail', 'trim|required|is_unique[mitarbeiter.email]');
		$this->form_validation->set_rules('groups', 'Group', 'required');
		$this->form_validation->set_rules('birthday', 'Geburtstag', 'trim');
		$this->form_validation->set_rules('phone', 'Telefon', 'trim');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');


		if ($this->form_validation->run() == true) {
			// true case
			$password = $this->password_hash($this->input->post('password'));
			$data = array(
				'name' => $this->input->post('lastname'),
				'vorname' => $this->input->post('firstname'),
				'email' => $this->input->post('email'),
				'geburtsdatum' => $this->input->post('birthday'),
				'telefon' => $this->input->post('phone'),
				'geschlecht' => $this->input->post('gender'),
				'geburtsdatum' => $this->input->post('birthday'),
				'status' => $this->input->post('status'),
				'password' => $password,
			);

			$create = $this->model_users->create($data, $this->input->post('groups'));
			if ($create == true) {
				$this->session->set_flashdata('success', 'Mitarbeiter erfolgreich angelegt');
				redirect('users/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Beim Anlegen des Mitarbeiters ist ein Fehler in der Datenbank aufgetreten');
				redirect('users/create', 'refresh');
			}
		} else {
			$group_data = $this->model_groups->getGroupData();
			$this->data['group_data'] = $group_data;

			$this->render_template('users/create', $this->data);
		}
	}

	public function password_hash($pass = '')
	{
		if ($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function edit($id = null)
	{

		if (!in_array('updateUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			//$this->form_validation->set_rules('firstname', 'Vorname', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Nachname', 'trim|required');
			$this->form_validation->set_rules('email', 'E-Mail', 'trim|required');
			$this->form_validation->set_rules('groups', 'Group', 'required');
			$this->form_validation->set_rules('birthday', 'Geburtstag', 'trim');
			$this->form_validation->set_rules('phone', 'Telefon', 'trim');


			if ($this->form_validation->run() == true) {
				// true case
				if (empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
					$data = array(
						'name' => $this->input->post('lastname'),
						'vorname' => $this->input->post('firstname'),
						'email' => $this->input->post('email'),
						'geburtsdatum' => $this->input->post('birthday'),
						'telefon' => $this->input->post('phone'),
						'geschlecht' => $this->input->post('gender'),
						'geburtsdatum' => $this->input->post('birthday'),
						'status' => $this->input->post('status'),
					);

					$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
					if ($update == true) {
						$this->session->set_flashdata('success', 'Mitarbeiter ohne Passwortänderung erfolgreich gespeichert');
						redirect('users/', 'refresh');
					} else {
						$this->session->set_flashdata('errors', 'Beim Speichern des Mitarbeiters ist ein Fehler in der Datenbank aufgetreten');
						redirect('users/edit/' . $id, 'refresh');
					}
				} else {
					$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if ($this->form_validation->run() == true) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
							'name' => $this->input->post('lastname'),
							'vorname' => $this->input->post('firstname'),
							'email' => $this->input->post('email'),
							'geburtsdatum' => $this->input->post('birthday'),
							'telefon' => $this->input->post('phone'),
							'geschlecht' => $this->input->post('gender'),
							'geburtsdatum' => $this->input->post('birthday'),
							'status' => $this->input->post('status'),
							'password' => $password,
						);

						$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
						if ($update == true) {
							$this->session->set_flashdata('success', 'Mitarbeiter mit Passwortänderung erfolgreich gespeichert');
							redirect('users/', 'refresh');
						} else {
							$this->session->set_flashdata('errors', 'Beim Speichern des Mitarbeiters ist ein Fehler in der Datenbank aufgetreten');
							redirect('users/edit/' . $id, 'refresh');
						}
					} else {
						// false case
						$user_data = $this->model_users->getUserData($id);
						$groups = $this->model_users->getUserGroup($id);

						$this->data['user_data'] = $user_data;
						$this->data['user_group'] = $groups;

						$group_data = $this->model_groups->getGroupData();
						$this->data['group_data'] = $group_data;

						$this->render_template('users/edit', $this->data);
					}
				}
			} else {
				// false case
				$user_data = $this->model_users->getUserData($id);
				$groups = $this->model_users->getUserGroup($id);

				//$this->data['store_data'] = $this->model_stores->getStoresData();

				$this->data['user_data'] = $user_data;
				$this->data['user_group'] = $groups;

				$group_data = $this->model_groups->getGroupData();
				$this->data['group_data'] = $group_data;

				$this->render_template('users/edit', $this->data);
			}
		}
	}

	public function delete($id)
	{

		if (!in_array('deleteUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			if ($this->input->post('confirm')) {


				$delete = $this->model_users->delete($id);
				if ($delete == true) {
					$this->session->set_flashdata('success', 'Successfully removed');
					redirect('users/', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('users/delete/' . $id, 'refresh');
				}
			} else {
				$this->data['id'] = $id;
				$this->render_template('users/delete', $this->data);
			}
		}
	}

	public function profile()
	{

		if (!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_id = $this->session->userdata('id');

		$user_data = $this->model_users->getUserData($user_id);
		$this->data['user_data'] = $user_data;

		$user_group = $this->model_users->getUserGroup($user_id);
		$this->data['user_group'] = $user_group;

		$this->render_template('users/profile', $this->data);
	}

	public function setting()
	{
		if (!in_array('updateProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->session->userdata('id');

		if ($id) {
			//$this->form_validation->set_rules('firstname', 'Vorname', 'trim|required');
			//$this->form_validation->set_rules('lastname', 'Nachname', 'trim|required');
			$this->form_validation->set_rules('email', 'E-Mail', 'trim|required');
			//$this->form_validation->set_rules('groups', 'Group', 'required');
			//$this->form_validation->set_rules('birthday', 'Geburtstag', 'trim');
			$this->form_validation->set_rules('phone', 'Telefon', 'trim');

			if ($this->form_validation->run() == true) {
				// true case
				if (empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
					$data = array(
						//'name' => $this->input->post('lastname'),
						//'vorname' => $this->input->post('firstname'),
						'email' => $this->input->post('email'),
						//'geburtsdatum' => $this->input->post('birthday'),
						'telefon' => $this->input->post('phone'),
						//'geschlecht' => $this->input->post('gender'),
						//'geburtsdatum' => $this->input->post('birthday'),
						//'status' => $this->input->post('status'),
					);

					$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
					if ($update == true) {
						$this->session->set_flashdata('success', 'Benutzerdaten ohne Passwortänderung erfolgreich gespeichert');
						redirect('users/setting/', 'refresh');
					} else {
						$this->session->set_flashdata('errors', 'Beim Speichern der Benutzerdaten ist ein Fehler in der Datenbank aufgetreten');
						redirect('users/setting/', 'refresh');
					}
				} else {
					$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if ($this->form_validation->run() == true) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
							//'name' => $this->input->post('lastname'),
							//'vorname' => $this->input->post('firstname'),
							'email' => $this->input->post('email'),
							//'geburtsdatum' => $this->input->post('birthday'),
							'telefon' => $this->input->post('phone'),
							//'geschlecht' => $this->input->post('gender'),
							//'geburtsdatum' => $this->input->post('birthday'),
							//'status' => $this->input->post('status'),
							'password' => $password,
						);

						$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
						if ($update == true) {
							$this->session->set_flashdata('success', 'Benutzerdaten mit Passwortänderung erfolgreich gespeichert');
							redirect('users/setting/', 'refresh');
						} else {
							$this->session->set_flashdata('errors', 'Beim Speichern der Benutzerdaten ist ein Fehler in der Datenbank aufgetreten');
							redirect('users/setting/', 'refresh');
						}
					} else {
						// false case
						$user_data = $this->model_users->getUserData($id);
						$groups = $this->model_users->getUserGroup($id);

						$this->data['user_data'] = $user_data;
						$this->data['user_group'] = $groups;

						$group_data = $this->model_groups->getGroupData();
						$this->data['group_data'] = $group_data;

						$this->render_template('users/setting', $this->data);
					}
				}
			} else {
				// false case
				$user_data = $this->model_users->getUserData($id);
				$groups = $this->model_users->getUserGroup($id);

				$this->data['user_data'] = $user_data;
				$this->data['user_group'] = $groups;

				$group_data = $this->model_groups->getGroupData();
				$this->data['group_data'] = $group_data;

				$this->render_template('users/setting', $this->data);
			}
		}
	}
}

