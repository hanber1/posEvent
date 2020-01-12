<?php 

class Model_category extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getData($id = null)
	{

		//category
		if ($id) {
			$sql = "SELECT * FROM artikelkategorie WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM artikelkategorie ORDER BY bezeichnung";
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

			$create = $this->db->insert('artikelkategorie', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if ($id && $data) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');

			$this->db->where('id', $id);
			$update = $this->db->update('artikelkategorie', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('artikelkategorie');
			return ($delete == true) ? true : false;
		}
	}

	public function getActive()
	{
		$sql = "SELECT * FROM artikelkategorie WHERE status = ? ORDER BY reihenfolge asc";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
}

