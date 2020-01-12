<?php 

class Model_article extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM artikel WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM artikel ORDER BY bezeichnung ASC";
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
			$create = $this->db->insert('artikel', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if ($id && $data) {
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');
			$this->db->where('id', $id);
			$update = $this->db->update('artikel', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('artikel');
			return ($delete == true) ? true : false;
		}
	}

	public function getActive()
	{
		$sql = "SELECT * FROM artikel WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getActiveUnit()
	{
		$sql = "SELECT artikel.id, artikel.bezeichnung as artikel, artikeleinheit.bezeichnung as einheit FROM artikel 
		INNER JOIN artikeleinheit ON artikel.idArtikeleinheit = artikeleinheit.id  
		WHERE artikel.status = ?";
		$query = $this->db->query($sql, array(1));

		return $query->result_array();
	}
}

