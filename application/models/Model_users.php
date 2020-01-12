<?php

class Model_users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_eventuser');
	}

	public function getUserData($userId = null)
	{
		if ($userId) {
			$sql = "SELECT * FROM mitarbeiter WHERE id = ?";
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM mitarbeiter WHERE id != ? ORDER BY name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getUserGroup($userId = null)
	{
		if ($userId) {
			$sql = "SELECT * FROM mitarbeiter_gruppe WHERE idMitarbeiter = ?";
			$query = $this->db->query($sql, array($userId));
			$result = $query->row_array();

			$group_id = $result['idGruppe'];
			$g_sql = "SELECT * FROM gruppe WHERE id = ?";
			$g_query = $this->db->query($g_sql, array($group_id));
			$q_result = $g_query->row_array();
			return $q_result;
		}
	}

	public function create($data = '', $group_id = null)
	{

		if ($data && $group_id) {
			$data['created'] = date("Y-m-d H:i:s");
			$data['createdBy'] = $this->session->userdata('id');
			$data['updated'] = date("Y-m-d H:i:s");
			$data['updatedBy'] = $this->session->userdata('id');

			$create = $this->db->insert('mitarbeiter', $data);

			$user_id = $this->db->insert_id();

			$group_data = array(
				'idMitarbeiter' => $user_id,
				'idGruppe' => $group_id
			);

			$group_data = $this->db->insert('mitarbeiter_gruppe', $group_data);

			return ($create == true && $group_data) ? true : false;
		}
	}

	public function edit($data = array(), $id = null, $group_id = null)
	{
		$this->db->where('id', $id);
		$data['updated'] = date("Y-m-d H:i:s");
		$data['updatedBy'] = $this->session->userdata('id');

		$update = $this->db->update('mitarbeiter', $data);

		if ($group_id) {
			// user group
			$update_user_group = array('idGruppe' => $group_id);
			$this->db->where('idMitarbeiter', $id);
			$user_group = $this->db->update('mitarbeiter_gruppe', $update_user_group);
			return ($update == true && $user_group == true) ? true : false;
		}

		return ($update == true) ? true : false;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('mitarbeiter');
		return ($delete == true) ? true : false;
	}

	public function countTotalUsers()
	{
		$sql = "SELECT * FROM mitarbeiter WHERE id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

	public function getActive()
	{
		$sql = "SELECT * FROM mitarbeiter WHERE status = ? AND id > 1";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getFreeEventday($ev_id)
	{
		$sql = "SELECT * FROM mitarbeiter WHERE status = ? AND id > 1";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();



		// $sql = "SELECT mitarbeiter.name, mitarbeiter.vorname, mitarbeiter.id
		// FROM mitarbeiter
		// join festmitarbeiter on mitarbeiter.id = festmitarbeiter.idMitarbeiter
		// where mitarbeiter.id > 1 and festmitarbeiter.idFesttag = ?";
		// $query = $this->db->query($sql, array($ev_id));
		// return $query->result_array();
	}

	public function getComplete($id)
	{
		if ($id) {
			$user = $this->getUserData($id);

			$result['name'] = $user['name'] . " " . $user['vorname'];

			return $result;
		}
	}
}
