<?php 

class Article extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Artikel';
		$this->load->model('model_article');
		$this->load->model('model_category');
		$this->load->model('model_unit');
	}

	public function index()
	{	
		$article_data = $this->model_article->getData();
		$this->data['article_data'] = $article_data;
		$category_data = $this->model_category->getActive();
		$this->data['category_data'] = $category_data;
		$unit_data = $this->model_unit->getActive();
		$this->data['unit_data'] = $unit_data;
		$this->render_template('article/index', $this->data);

	}

	public function fetchData()
	{
		//if(!in_array('viewArticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$result = array('data' => array());

		$data = $this->model_article->getData();

		foreach ($data as $key => $value) {

			$category_data = $this->model_category->getData($value['idArtikelkategorie']);
			$unit_data = $this->model_unit->getData($value['idArtikeleinheit']);

			// button
			$buttons = '';

			if(in_array('updateArticle', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteArticle', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			$status = ($value['status'] == 1) ? '<span class="label label-success">Aktiv</span>' : '<span class="label label-warning">Inaktiv</span>';

			$result['data'][$key] = array(
				$value['bezeichnung'],
				$unit_data['bezeichnung'],
				$category_data['bezeichnung'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		//if(!in_array('createArticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		$this->form_validation->set_rules('article_name', 'Artikelname', 'trim|required');
		$this->form_validation->set_rules('category', 'Artikelkategorie', 'trim|integer');
		$this->form_validation->set_rules('unit', 'Artikeleinheit', 'trim|integer');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'bezeichnung' => $this->input->post('article_name'),
        		'idArtikelkategorie' => $this->input->post('category'),	
        		'idArtikeleinheit' => $this->input->post('unit'),	
        		'status' => $this->input->post('status'),	
        	);

        	$create = $this->model_article->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Artikel erfolgreich angelegt';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Beim Anlegen des Artikels ist ein Fehler in der Datenbank aufgetreten';			
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
			$data = $this->model_article->getData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		//if(!in_array('updateArticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		if($id) {

			$this->form_validation->set_rules('edit_article_name', 'Artikelname', 'trim|required');
			$this->form_validation->set_rules('edit_category', 'Artikelkategorie', 'trim|integer');
			$this->form_validation->set_rules('edit_unit', 'Artikeleinheit', 'trim|integer');
			$this->form_validation->set_rules('edit_status', 'Status', 'trim|required');
	
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
					'bezeichnung' => $this->input->post('edit_article_name'),
					'idArtikelkategorie' => $this->input->post('edit_category'),	
					'idArtikeleinheit' => $this->input->post('edit_unit'),	
					'status' => $this->input->post('edit_status'),	
	        	);

	        	$update = $this->model_article->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Artikel erfolgreich gespeichert';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Beim Speichern des Artikels ist ein Fehler in der Datenbank aufgetreten';			
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
		//if(!in_array('deleteArticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$article_id = $this->input->post('article_id');

		$response = array();
		if($article_id) {
			$delete = $this->model_article->remove($article_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Artikel erfolgreich gelöscht";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen des Artikels ist ein Fehler in der Datenbank aufgetreten";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

}