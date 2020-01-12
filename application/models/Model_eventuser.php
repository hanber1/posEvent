<?php

class Model_eventuser extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_users');
		$this->load->model('model_eventday');
		$this->load->model('model_event');
		$this->load->model('model_eventfunction');
	}

	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM festmitarbeiter WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM festmitarbeiter ORDER BY idFesttag DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getIdByNumber($number = null, $eventday = null)
	{
		if ($number) {
			$sql = "SELECT id FROM festmitarbeiter Where nummer = ? and idfesttag = ? and status = ?";
			$query = $this->db->query($sql, array($number, $eventday, 2));
			$return = $query->row_array();
			return ($return == true) ? $return : false;
		}
	}

	//Nur die noch freien Mitarbeiter abfragen
	public function getRemainingUser($eventday = null){
		if ($eventday) {
			$sql = "SELECT mitarbeiter.id, mitarbeiter.name, mitarbeiter.vorname FROM mitarbeiter
					WHERE mitarbeiter.status = 1 AND mitarbeiter.id > 1 AND mitarbeiter.id NOT IN (
						SELECT festmitarbeiter.idMitarbeiter FROM festmitarbeiter where festmitarbeiter.idFesttag = ?) order by mitarbeiter.name asc";
			$query = $this->db->query($sql, array($eventday));
			$return = $query->result_array();
			return ($return == true) ? $return : false;
					}
	}

	//Naechste freie Kellnernummer ermitteln damit beim Anlegen eines Festmitarbeiters automatisch eine neue freie Nummer eingetragen wird
	public function getNextFreeNumber($eventday = null)
	{
		if ($eventday) {
			$sql = "SELECT nummer FROM festmitarbeiter Where nummer != '' and idfesttag = ? order by nummer";
			$query = $this->db->query($sql, array($eventday));
			$data = $query->result_array();

			//$count = $query->num_rows();
			$count = 1;
			$readyNum = false;

			if ($data) {
				foreach ($data as $key => $value) {
					if ($value['nummer'] != $count) {
						$return = $count;
						$readyNum = true; 
						break;
					}
					$count = $count + 1;
				}
				if ($readyNum == false) {
					$return = $count;
				}

			}
			else{
				$return = 1;
			}


			return ($return == true) ? $return : false;
		}
	}

	public function getDataEventday($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT * FROM festmitarbeiter WHERE idFesttag = ? ORDER BY idMitarbeiter ASC";
			$query = $this->db->query($sql, array($ed_id));
			return $query->result_array();
		}
	}

	public function getInServiceComplete($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT festmitarbeiter.id, festmitarbeiter.status, festmitarbeiter.idFesttag as idFesttag, festmitarbeiter.nummer as nummer, mitarbeiter.name as name, mitarbeiter.vorname as vorname FROM festmitarbeiter 
			INNER JOIN mitarbeiter ON festmitarbeiter.idMitarbeiter = mitarbeiter.id WHERE idFesttag = ? AND festmitarbeiter.status = ? ORDER BY name";
			$query = $this->db->query($sql, array($ed_id, 2));
			$data = $query->result_array();
		} else {
			$sql = "SELECT festmitarbeiter.id, festmitarbeiter.status, festmitarbeiter.nummer as nummer, mitarbeiter.name as name, mitarbeiter.vorname as vorname FROM festmitarbeiter 
			INNER JOIN mitarbeiter ON festmitarbeiter.idMitarbeiter = mitarbeiter.id WHERE festmitarbeiter.status = ? ORDER BY name";
			$query = $this->db->query($sql, array(2));
			$data =  $query->result_array();
		}

		if ($data) {
			foreach ($data as $key => $value) {

				//				$username = $this->model_users->getUserData($value['idMitarbeiter']);

				$result[$key]['id'] = $value['id'];
				$result[$key]['nummer'] = $value['nummer'];
				$result[$key]['name'] = $value['name'] . " " . $value['vorname'];
			} //foreach

			return $result;
		} else {
			return false;
		}
	}

	public function getActiveEvent($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT festtag.id, festtag.bezeichnung as festtag, fest.bezeichnung as fest FROM festtag 
			INNER JOIN fest ON festtag.idFest = fest.id WHERE festtag.id = ?";
			$query = $this->db->query($sql, array($ed_id));
			return $query->result_array();
		} else {

			$sql = "SELECT festtag.id, festtag.bezeichnung as festtag, fest.bezeichnung as fest FROM festtag 
		INNER JOIN fest ON festtag.idFest = fest.id";
			$query = $this->db->query($sql);

			return $query->result_array();
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
			$create = $this->db->insert('festmitarbeiter', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if ($id && $data) {
			//$data['aktSumme'] = "0";
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('festmitarbeiter', $data);
			return ($update == true) ? true : false;
		}
	}

	public function service($id = null, $data = array())
	{


		if ($id) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('festmitarbeiter', $data);
			return ($update == true) ? true : false;
		}
	}

	public function updateCash($id = null, $summe = null)
	{

		if ($id) {
			$sqlAbfrage = "SELECT aktSumme FROM festmitarbeiter WHERE id = ?";
			$query = $this->db->query($sqlAbfrage, array($id));
			$aktSumme = $query->row_array();

			$data['aktSumme'] = $aktSumme['aktSumme'] + $summe;

			$this->db->where('id', $id);
			$update = $this->db->update('festmitarbeiter', $data);
			return ($update == true) ? true : false;
		}
	}

	public function cashupservice($id = null, $data = array())
	{


		if ($id) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('festmitarbeiter', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('festmitarbeiter');
			return ($delete == true) ? true : false;
		}
	}

	public function getActive()
	{

		$sql = "SELECT * FROM festmitarbeiter WHERE status = ?";
		$query = $this->db->query($sql, array(2));
		return $query->result_array();
	}

	public function getComplete($id)
	{
		if ($id) {
			$eventuser = $this->getData($id);
			$name = $this->model_users->getUserData($eventuser['idMitarbeiter']);
			$event = $this->model_eventday->getEventdayEventData($eventuser['idFesttag']);
			$eventfunction = $this->model_eventfunction->getData($eventuser['idFestfunktion']);

			$result['name'] = $name['name'] . " " . $name['vorname'];
			$result['festtag'] = $event;
			$result['festfunktion'] = $eventfunction['bezeichnung'];

			return $result;
		}
	}

	public function getName($id)
	{
		if ($id) {
			$eventuser = $this->getData($id);
			$name = $this->model_users->getUserData($eventuser['idMitarbeiter']);

			$result = $name['vorname'] . " " . $name['name'];

			return $result;
		}
	}

	public function getActiveComplete($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT * FROM festmitarbeiter WHERE idFesttag = ? AND status = ?";
			$query = $this->db->query($sql, array($ed_id, 2));
			$data = $query->result_array();
		} else {
			$sql = "SELECT * FROM festmitarbeiter WHERE status = ?";
			$query = $this->db->query($sql, array(2));
			$data = $query->result_array();
		}

		if ($data) {
			foreach ($data as $key => $value) {

				$username = $this->model_users->getUserData($value['idMitarbeiter']);
				$userfunction = $this->model_eventfunction->getData($value['idFestfunktion']);

				$result[$key]['name'] = $username['name'] . " " . $username['vorname'];
				$result[$key]['funktion'] = $userfunction['bezeichnung'];
				$result[$key]['aktSumme'] = $value['aktSumme'];
			} //foreach

			return $result;
		} else {
			return false;
		}
	}

	public function countActive($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT * FROM festmitarbeiter WHERE idFesttag = ? AND status = ?";
			$query = $this->db->query($sql, array($ed_id, 2));
			return $query->num_rows();
		} else {
			$sql = "SELECT * FROM festmitarbeiter WHERE status = ?";
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
}
