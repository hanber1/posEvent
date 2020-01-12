<?php 

class Model_cashbook extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		// $this->load->model('model_users');
		// $this->load->model('model_eventday');
		// $this->load->model('model_event');
		// $this->load->model('model_eventfunction');
	}

	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM kassabuch WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM kassabuch ORDER BY created DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getDataEventday($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT * FROM kassabuch WHERE idFesttag = ? ORDER BY created DESC";
			$query = $this->db->query($sql, array($ed_id));
			return $query->result_array();
		}
	}

	public function create($data = array())
	{
		if ($data) {
			$data['created'] = date("Y-m-d H:i:s");
			$data['createdBy'] = $this->session->userdata('id');
			$create = $this->db->insert('kassabuch', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if ($id && $data) {
			// $data['updated'] = date("Y-m-d H:i:s");
			// $data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('kassabuch', $data);
			return ($update == true) ? true : false;
		}
	}


	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('kassabuch');
			return ($delete == true) ? true : false;
		}
	}
}

