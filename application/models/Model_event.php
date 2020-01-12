<?php 

class Model_event extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM fest WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM fest ORDER BY bezeichnung DESC";
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
			$create = $this->db->insert('fest', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if ($id && $data) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('fest', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('fest');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotal()
	{
		$sql = "SELECT * FROM fest";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
}

