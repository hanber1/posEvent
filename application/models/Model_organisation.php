<?php 

class Model_organisation extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the company data */
	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM organisation WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}

	public function update($data, $id)
	{
		if ($data && $id) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('organisation', $data);
			return ($update == true) ? true : false;
		}
	}
}

