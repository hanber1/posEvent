<?php 

class Model_eventday extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_event');
	}

	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM festtag WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM festtag ORDER BY datum DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = array())
	{
		if ($data) {
			$data['created'] = date("Y-m-d H:i:s");
			$data['createdBy'] = $this->session->userdata('id');
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$create = $this->db->insert('festtag', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if ($id && $data) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('festtag', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('festtag');
			return ($delete == true) ? true : false;
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
		
		$sql = "SELECT festtag.id, festtag.status, festtag.bezeichnung as festtag, fest.bezeichnung as fest FROM festtag 
		INNER JOIN fest ON festtag.idFest = fest.id WHERE festtag.status = 1";
		$query = $this->db->query($sql);

		return $query->result_array();
		}
	}

	public function getActive()
	{
		$sql = "SELECT * FROM festtag WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getEventdayEventData($id = null)
	{
		if ($id) {
			$day = $this->model_eventday->getData($id);
			$event = $this->model_event->getData($day['idFest']);

			$eventday = $event['bezeichnung'] . " / " . $day['bezeichnung'];

			return $eventday;
		} else {
			return false;
		}
	}
}

