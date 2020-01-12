<?php 

class Eventarticle extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Festartikel';
		$this->load->model('model_eventarticle');
		//$this->load->model('model_category');
		$this->load->model('model_article');
		//$this->load->model('model_event');
		$this->load->model('model_eventday');
	}

	public function index()
	{	
		$articleUnit = $this->model_article->getActiveUnit();
		$this->data['articleUnit'] = $articleUnit;
		if ($this->session->userdata('id') == 1) {
			$eventdayEvent = $this->model_eventday->getActiveEvent();
			$this->data['eventdayEvent'] = $eventdayEvent;
		} else {
			$eventdayEvent = $this->model_eventday->getActiveEvent($this->session->userdata('eventday'));
			$this->data['eventdayEvent'] = $eventdayEvent;
		}
		//$event_data = $this->model_event->getData();
		//$this->data['event_data'] = $event_data;
		//$category_data = $this->model_category->getActive();
		//$this->data['category_data'] = $category_data;
		//$unit_data = $this->model_unit->getActive();
		//$this->data['unit_data'] = $unit_data;
		$this->render_template('eventarticle/index', $this->data);
	}

	public function fetchData()
	{
		//if(!in_array('viewEventarticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$result = array('data' => array());

		if ($this->session->userdata('id') == 1) {
			$data = $this->model_eventarticle->getData();
		} else {
			$data = $this->model_eventarticle->getDataEventday($this->session->userdata('eventday'));
		}

		foreach ($data as $key => $value) {

			$article_data = $this->model_eventarticle->getArticleUnitData($value['idArtikel']);
			//$article = $this->model_article->getData($article_data['id']);
			//$unit_data = $this->model_unit->getData($article_data['idArtikeleinheit']);
			$eventday_data = $this->model_eventday->getEventdayEventData($value['idFesttag']);
			//$event_data = $this->model_event->getData($eventday_data['idFest']);
			//$category_data = $this->model_category->getData($article['idArtikelkategorie']);

			// button
			$buttons = '';

			if(in_array('updateEventarticle', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-primary" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal" title="Bearbeiten"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteEventarticle', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			$result['data'][$key] = array(
				$article_data,
				//$category_data['bezeichnung'],
				$eventday_data,
				$value['preis'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		//if(!in_array('createEventarticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		$this->form_validation->set_rules('eventarticle', 'Festartikel', 'trim|integer|greater_than[0]');
		$this->form_validation->set_rules('eventday', 'Festtag', 'trim|integer');
		$this->form_validation->set_rules('price', 'Preis', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'idArtikel' => $this->input->post('eventarticle'),
        		'idFesttag' => $this->input->post('eventday'),	
        		'preis' => $this->input->post('price'),	
        	);

        	$create = $this->model_eventarticle->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Festartikel erfolgreich angelegt';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Beim Anlegen des Festartikels ist ein Fehler in der Datenbank aufgetreten';			
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
			$data = $this->model_eventarticle->getData($id);
			echo json_encode($data);
		}
		
	}

	public function fetchArticleDataById($id = null)
	{
		if($id) {
			$data = $this->model_eventarticle->getArticle($id);
			echo json_encode($data);
		}
		
	}

	public function getRemainingArticle()
	{
		$data = $this->model_eventarticle->getRemainingArticle($this->session->userdata('eventday'));
		echo json_encode($data);
	}

	public function update($id)
	{
		//if(!in_array('updateEventarticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}

		$response = array();

		if($id) {

			//$this->form_validation->set_rules('edit_eventarticle', 'Festartikel', 'trim|integer');
			//$this->form_validation->set_rules('edit_eventday', 'Festtag', 'trim|integer');
			$this->form_validation->set_rules('edit_price', 'Preis', 'trim');
	
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
	
			if ($this->form_validation->run() == TRUE) {
				$data = array(
					//'idArtikel' => $this->input->post('edit_eventarticle'),
					//'idFesttag' => $this->input->post('edit_eventday'),	
					'preis' => $this->input->post('edit_price'),	
				);

	        	$update = $this->model_eventarticle->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Festartikel erfolgreich gespeichert';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Beim Speichern des Festartikels ist ein Fehler in der Datenbank aufgetreten';			
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
		//if(!in_array('deleteEventarticle', $this->permission)) {
		//	redirect('dashboard', 'refresh');
		//}
		
		$eventarticle_id = $this->input->post('eventarticle_id');

		$response = array();
		if($eventarticle_id) {
			$delete = $this->model_eventarticle->remove($eventarticle_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Festartikel erfolgreich gelöscht";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen des Festartikels ist ein Fehler in der Datenbank aufgetreten";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

}