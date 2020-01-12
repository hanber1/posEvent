<?php 

class Model_eventfunction extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM festfunktion WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM festfunktion ORDER BY bezeichnung";
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
			$create = $this->db->insert('festfunktion', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if ($id && $data) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('festfunktion', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('festfunktion');
			return ($delete == true) ? true : false;
		}
	}

	public function getActive()
	{
		$sql = "SELECT * FROM festfunktion WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
}

