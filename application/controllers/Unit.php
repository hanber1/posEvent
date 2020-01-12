<?php 

class Unit extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Artikeleinheit';
		$this->load->model('model_unit');
	}

	public function index()
	{
		$this->render_template('unit/index', $this->data);
	}

	public function fetchData()
	{
		$result = array('data' => array());

		$data = $this->model_unit->getData();

		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if (in_array('updateUnit', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if (in_array('deleteUnit', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
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
		// if(!in_array('createUnit', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		$this->form_validation->set_rules('unit_name', 'Artikeleinheit', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() == true) {
			$data = array(
				'bezeichnung' => $this->input->post('unit_name'),
				'status' => $this->input->post('status'),
			);

			$create = $this->model_unit->create($data);
			if ($create == true) {
				$response['success'] = true;
				$response['messages'] = 'Artikeleinheit erfolgreich angelegt';
			} else {
				$response['success'] = false;
				$response['messages'] = 'Beim Anlegen der Artikeleinheit ist ein Fehler in der Datenbank aufgetreten';
			}
		} else {
			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($response);
	}

	public function fetchDataById($id = null)
	{
		if ($id) {
			$data = $this->model_unit->getData($id);
			echo json_encode($data);
		}
	}

	public function update($id)
	{
		// if(!in_array('updateUnit', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		if ($id) {
			$this->form_validation->set_rules('edit_unit_name', 'Artikeleinheit', 'trim|required');
			$this->form_validation->set_rules('edit_status', 'Status', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() == true) {
				$data = array(
					'bezeichnung' => $this->input->post('edit_unit_name'),
					'status' => $this->input->post('edit_status'),
				);

				$update = $this->model_unit->update($id, $data);
				if ($update == true) {
					$response['success'] = true;
					$response['messages'] = 'Artikeleinheit erfolgreich gespeichert';
				} else {
					$response['success'] = false;
					$response['messages'] = 'Beim Speichern der Artikeleinheit ist ein Fehler in der Datenbank aufgetreten';
				}
			} else {
				$response['success'] = false;
				foreach ($_POST as $key => $value) {
					$response['messages'][$key] = form_error($key);
				}
			}
		} else {
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

		$unit_id = $this->input->post('unit_id');

		$response = array();
		if ($unit_id) {
			$delete = $this->model_unit->remove($unit_id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Artikeleinheit erfolgreich gelöscht";
			} else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen der Artikeleinheit ist ein Fehler in der Datenbank aufgetreten";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}
}

