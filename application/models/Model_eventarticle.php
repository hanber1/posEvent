<?php

class Model_eventarticle extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_article');
		$this->load->model('model_unit');
		$this->load->model('model_category');
		$this->load->model('model_eventday');
		$this->load->model('model_event');
	}

	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM festartikel WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM festartikel ORDER BY idFesttag DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getDataEventday($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT * FROM festartikel WHERE idFesttag = ? ORDER BY idArtikel ASC";
			$query = $this->db->query($sql, array($ed_id));
			return $query->result_array();
		}
	}

	//Nur die noch freien Artikel abfragen
	public function getRemainingArticle($eventday = null)
	{
		if ($eventday) {
			$sql = "SELECT artikel.id, artikeleinheit.bezeichnung as einheit, artikel.bezeichnung as artikel FROM artikel
			INNER JOIN artikeleinheit on artikel.idArtikeleinheit = artikeleinheit.id
			WHERE artikel.status = 1 AND artikel.id NOT IN (
			SELECT festartikel.idArtikel FROM festartikel where festartikel.idFesttag = ?)";
			$query = $this->db->query($sql, array($eventday));
			$return = $query->result_array();
			return ($return == true) ? $return : false;
		}
	}


	public function create($data = array())
	{
		if ($data) {
			$data['created'] = date("Y-m-d H:i:s");
			$data['createdBy'] = $this->session->userdata('id');
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$create = $this->db->insert('festartikel', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if ($id && $data) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('festartikel', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('festartikel');
			return ($delete == true) ? true : false;
		}
	}

	public function getArticleUnitData($id = null)
	{
		if ($id) {
			$article = $this->model_article->getData($id);
			$unit = $this->model_unit->getData($article['idArtikeleinheit']);

			$articleUnit = $unit['bezeichnung'] . " " . $article['bezeichnung'];

			return /*($article['status'] == 1) ? */$articleUnit;
		} else {
			return false;
		}
	}

	public function getArticle($id = null)
	{
		if ($id) {
			$sql = "SELECT festartikel.id as id, artikel.bezeichnung AS name, artikeleinheit.bezeichnung AS einheit, artikelkategorie.bezeichnung AS kategorie, artikelkategorie.id AS idKategorie, artikelkategorie.gutschein AS gutschein, festartikel.preis AS preis from festartikel
			INNER JOIN artikel on festartikel.idArtikel = artikel.id 
			INNER JOIN artikeleinheit on artikel.idArtikeleinheit = artikeleinheit.id 
			INNER JOIN artikelkategorie on artikel.idArtikelkategorie = artikelkategorie.id
			WHERE festartikel.id =  ?";
			$query = $this->db->query($sql, array($id));
			$article = $query->row_array();

			return $article;
		} else {
			return false;
		}
	}

	public function getArticlePos($evDay = null)
	{

		if ($evDay) {

			$result = NULL;
			$count = NULL;

			$sql = "SELECT artikel.bezeichnung AS name, artikeleinheit.bezeichnung AS einheit, artikelkategorie.bezeichnung AS kategorie, artikelkategorie.id AS idKategorie, artikelkategorie.reihenfolge AS sortKategorie, festartikel.id AS id, festartikel.preis AS preis from festartikel
			INNER JOIN artikel on festartikel.idArtikel = artikel.id 
			INNER JOIN artikeleinheit on artikel.idArtikeleinheit = artikeleinheit.id 
			INNER JOIN artikelkategorie on artikel.idArtikelkategorie = artikelkategorie.id
			WHERE idFesttag = ? ORDER BY sortKategorie ASC, preis DESC, name ASC";
			$query = $this->db->query($sql, array($evDay));
			$eventArticle = $query->result_array();


			foreach ($eventArticle as $key => $value) {
				$articleUnit = $value['einheit'] . " " . $value['name'];

				$result[$key] = array(
					"id" => $value['id'],
					"name" => $value['name'],
					"einheit" => $value['einheit'],
					"idKategorie" => $value['idKategorie'],
					"kategorie" => $value['kategorie'],
					"artikelVoll" => $articleUnit,
					"preis" => $value['preis']
				);
			}

			return $result;
		} else {
			return false;
		}
	}
}
