<?php 

class Model_groups extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getGroupData($groupId = null)
	{
		if ($groupId) {
			$sql = "SELECT * FROM gruppe WHERE id = ?";
			$query = $this->db->query($sql, array($groupId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM gruppe /*WHERE id != ?*/ ORDER BY id ASC";
		$query = $this->db->query($sql );
		return $query->result_array();
	}

	public function create($data = '')
	{
		$data['created'] = date("Y-m-d H:i:s");
		$data['createdBy'] = $this->session->userdata('id');
		$data['updated'] = date("Y-m-d H:i:s");
		$data['updatedBy'] = $this->session->userdata('id');

		$create = $this->db->insert('gruppe', $data);
		return ($create == true) ? true : false;
	}

	public function edit($data, $id)
	{
		$data['updated'] = date("Y-m-d H:i:s");
		$data['updatedBy'] = $this->session->userdata('id');

		$this->db->where('id', $id);
		$update = $this->db->update('gruppe', $data);
		return ($update == true) ? true : false;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('gruppe');
		return ($delete == true) ? true : false;
	}

	public function existInUserGroup($id)
	{
		$sql = "SELECT * FROM mitarbeiter_gruppe WHERE idGruppe = ?";
		$query = $this->db->query($sql, array($id));
		return ($query->num_rows() == 1) ? true : false;
	}

	public function getUserGroupByUserId($user_id)
	{
		$sql = "SELECT * FROM mitarbeiter_gruppe 
		INNER JOIN gruppe ON gruppe.id = mitarbeiter_gruppe.idGruppe 
		WHERE mitarbeiter_gruppe.idMitarbeiter = ?";
		$query = $this->db->query($sql, array($user_id));
		$result = $query->row_array();

		return $result;
	}
}

