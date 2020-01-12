<?php

class Category extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Artikelkategorie';
		$this->load->model('model_category');
	}

	public function index()
	{
		$this->render_template('category/index', $this->data);
	}

	public function fetchData()
	{
		$result = array('data' => array());

		$data = $this->model_category->getData();

		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			if (in_array('updateCategory', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if (in_array('deleteCategory', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['status'] == 1) ? '<span class="label label-success">Aktiv</span>' : '<span class="label label-warning">Inaktiv</span>';

			switch ($value['gutschein']) {
				case '1':
					$gutschein = '<span class="label label-primary">Getränke</span>';
					break;

				case '2':
					$gutschein = '<span class="label label-warning">Speisen</span>';
					break;

				default:
					$gutschein = '';
					break;
			}

			$result['data'][$key] = array(
				$value['bezeichnung'],
				$value['reihenfolge'],
				$gutschein,
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		// if(!in_array('createCategory', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		$this->form_validation->set_rules('category_name', 'Artikelkategorie', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'bezeichnung' => $this->input->post('category_name'),
				'reihenfolge' => $this->input->post('sort'),
				'gutschein' => $this->input->post('printvoucher'),
				'status' => $this->input->post('status'),
			);

			$create = $this->model_category->create($data);
			if ($create == true) {
				$response['success'] = true;
				$response['messages'] = 'Artikelkategorie erfolgreich angelegt';
			} else {
				$response['success'] = false;
				$response['messages'] = 'Beim Anlegen der Artikelkategorie ist ein Fehler in der Datenbank aufgetreten';
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
			$data = $this->model_category->getData($id);
			echo json_encode($data);
		}
	}

	public function update($id)
	{
		// if(!in_array('updateStore', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		if ($id) {
			$this->form_validation->set_rules('edit_category_name', 'Artikelkategorie', 'trim|required');
			$this->form_validation->set_rules('edit_status', 'Status', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() == TRUE) {
				$data = array(
					'bezeichnung' => $this->input->post('edit_category_name'),
					'reihenfolge' => $this->input->post('edit_sort'),
					'gutschein' => $this->input->post('edit_printvoucher'),
					'status' => $this->input->post('edit_status'),
				);

				$update = $this->model_category->update($id, $data);
				if ($update == true) {
					$response['success'] = true;
					$response['messages'] = 'Artikelkategorie erfolgreich gespeichert';
				} else {
					$response['success'] = false;
					$response['messages'] = 'Beim Speichern der Artikelkategorie ist ein Fehler in der Datenbank aufgetreten';
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
		// if(!in_array('deleteStore', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$category_id = $this->input->post('category_id');

		$response = array();
		if ($category_id) {
			$delete = $this->model_category->remove($category_id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Artikelkategorie erfolgreich gelöscht";
			} else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen der Artikelkategorie ist ein Fehler in der Datenbank aufgetreten";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}
}
