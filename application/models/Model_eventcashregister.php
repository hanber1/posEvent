<?php

class Model_eventcashregister extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_cashregister');
	}

	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM festkassa WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM festkassa ORDER BY idFesttag DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getDataEventday($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT * FROM festkassa WHERE idFesttag = ? ORDER BY idKassa ASC";
			$query = $this->db->query($sql, array($ed_id));
			return $query->result_array();
		}
	}

	public function getInServiceComplete($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT festkassa.id as id, festkassa.status, festkassa.idFesttag as idFesttag, kassa.bezeichnung as bezeichnung FROM festkassa 
			INNER JOIN kassa ON festkassa.idKassa = kassa.id WHERE idFesttag = ? AND festkassa.status = ? ORDER BY bezeichnung";
			$query = $this->db->query($sql, array($ed_id, 2));
			$data = $query->result_array();
		} else {
			$sql = "SELECT festkassa.id as id, festkassa.status, festkassa.idFesttag as idFesttag, kassa.bezeichnung as bezeichnung FROM festkassa 
			INNER JOIN kassa ON festkassa.idKassa = kassa.id WHERE festkassa.status = ? ORDER BY bezeichnung";
			$query = $this->db->query($sql, array(2));
			$data =  $query->result_array();
		}

		if ($data) {
			foreach ($data as $key => $value) {

				//				$username = $this->model_users->getUserData($value['idMitarbeiter']);

				$result[$key]['id'] = $value['id'];
				$result[$key]['bezeichnung'] = $value['bezeichnung'];
			} //foreach

			return $result;
		} else {
			return false;
		}
	}

	//Nur die noch freien Kassen abfragen
	public function getRemainingCashregister($eventday = null)
	{
		if ($eventday) {
			$sql = "SELECT kassa.id, kassa.bezeichnung FROM kassa
			WHERE kassa.status = 1 AND kassa.id NOT IN (
			SELECT festkassa.idKassa FROM festkassa where festkassa.idFesttag = ?) order by kassa.bezeichnung asc";
			$query = $this->db->query($sql, array($eventday));
			$return = $query->result_array();
			return ($return == true) ? $return : false;
		}
	}

	public function create($data = array())
	{
		if ($data) {
			$data['aktSumme'] = "0";
			$data['created'] = date("Y-m-d H:i:s");
			$data['createdBy'] = $this->session->userdata('id');
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$create = $this->db->insert('festkassa', $data);
			return ($create == true) ? true : false;
		}
	}

	public function service($id = null, $data = array())
	{

		if ($id) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('festkassa', $data);
			return ($update == true) ? true : false;
		}
	}

	public function updateCash($id = null, $summe = null)
	{

		if ($id) {
			$sqlAbfrage = "SELECT aktSumme FROM festkassa WHERE id = ?";
			$query = $this->db->query($sqlAbfrage, array($id));
			$aktSumme = $query->row_array();

			$data['aktSumme'] = $aktSumme['aktSumme'] + $summe;

			$this->db->where('id', $id);
			$update = $this->db->update('festkassa', $data);
			return ($update == true) ? true : false;
		}
	}

	public function cashupservice($id = null, $data = array())
	{

		if ($id) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('festkassa', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('festkassa');
			return ($delete == true) ? true : false;
		}
	}


	public function getActive()
	{

		$sql = "SELECT * FROM festkassa WHERE status = ?";
		$query = $this->db->query($sql, array(2));
		return $query->result_array();
	}

	public function countActive($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT * FROM festkassa WHERE idFesttag = ? AND status = ?";
			$query = $this->db->query($sql, array($ed_id, 2));
			return $query->num_rows();
		} else {
			$sql = "SELECT * FROM festkassa WHERE status = ?";
			$query = $this->db->query($sql, array(2));
			$count = $query->num_rows();
		}

		if ($count > 0) {
			$result = $count;
		} else {
			$result = 0;
		}

		return $result;
	}

	public function getComplete($id)
	{
		if ($id) {
			$eventcashregister = $this->getData($id);
			$name = $this->model_cashregister->getData($eventcashregister['idKassa']);
			$event = $this->model_eventday->getEventdayEventData($eventcashregister['idFesttag']);

			$result['name'] = $name['bezeichnung'];
			$result['festtag'] = $event;

			return $result;
		}
	}

	public function getActiveComplete($ed_id = null)
	{

		if ($ed_id) {
			$sql = "SELECT * FROM festkassa WHERE idFesttag = ? AND status = ?";
			$query = $this->db->query($sql, array($ed_id, 2));
			$data = $query->result_array();
		} else {
			$sql = "SELECT * FROM festkassa WHERE status = ?";
			$query = $this->db->query($sql, array(2));
			$data = $query->result_array();
		}

		if ($data) {
			foreach ($data as $key => $value) {

				$cashregister = $this->model_cashregister->getData($value['idKassa']);
				//$userfunction = $this->model_eventfunction->getData($value['idFestfunktion']);

				$result[$key]['bezeichnung'] = $cashregister['bezeichnung'];
				//$result[$key]['funktion'] = $userfunction['bezeichnung'];
			} //foreach

			return $result;
		} else {
			return false;
		}
	}
}
