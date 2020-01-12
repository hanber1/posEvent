<?php

class Model_order extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_eventuser');
		$this->load->model('model_eventcashregister');
		$this->load->model('model_eventarticle');
		$this->load->model('model_users');
		$this->load->model('model_eventday');
		$this->load->model('model_organisation');
		$this->load->model('model_print');
	}

	/* get the orders data */
	public function getData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM buchung WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		} else {
			$sql = "SELECT * FROM buchung ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}

	public function getDataEventday($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT * FROM buchung WHERE idFesttag = ? ORDER BY id DESC";
			$query = $this->db->query($sql, array($ed_id));
			return $query->result_array();
		}
	}

	// get the orders item data
	public function getOrderItemData($order_id = null)
	{
		if ($order_id) {
			$sql = "SELECT mitarbeiter.name as name, mitarbeiter.vorname as vorname, buchung.created as erstellt, buchung.gesamtsumme as buchungssumme, artikeleinheit.bezeichnung as einheit, artikel.bezeichnung as artikel, buchung_festartikel.menge as menge, buchung_festartikel.einzelsumme as einzelsumme, buchung_festartikel.gesamtsumme as gesamtsumme FROM buchung_festartikel
			INNER JOIN buchung on buchung_festartikel.idBuchung = buchung.id
			INNER JOIN festartikel on buchung_festartikel.idFestartikel = festartikel.id
			INNER JOIN artikel on festartikel.idArtikel = artikel.id
			INNER JOIN artikeleinheit on artikel.idArtikeleinheit = artikeleinheit.id
			INNER JOIN mitarbeiter on buchung.createdBy = mitarbeiter.id
			WHERE idBuchung = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->result_array();
		} else {
			return false;
		}
	}

	// Gesamtsumme Festtag
	public function getSumEventday_bak($ed_id = null, $person_id = null, $type = null)
	{
		if ($ed_id and $person_id and $type) {
			$sql = "SELECT SUM(gesamtsumme) as summe FROM buchung WHERE buchungstyp = ? and idPerson = ? and idFesttag = ?";
			$query = $this->db->query($sql, array($type, $person_id, $ed_id));
			return $query->row();
		} elseif ($ed_id) {
			$sql = "SELECT SUM(gesamtsumme) as summe FROM buchung WHERE idFesttag = ?";
			$query = $this->db->query($sql, array($ed_id));
			return $query->row();
		} {
			return false;
		}
	}

	// Gesamtsumme Festtag
	public function getSumEventday($ed_id = null)
	{
		if ($ed_id) {
			$sql = "SELECT SUM(gesamtsumme) as summe FROM buchung WHERE idFesttag = ?";
			$query = $this->db->query($sql, array($ed_id));
			$result = $query->row_array();
			return $result['summe'];
		} else {
			return false;
		}
	}

	//Buchung erstellen
	public function create()
	{
		if ($this->input->post('hidBuchungstyp') == 1) {
			$data = array(
				'rechnungsnummer' => '',
				'idFesttag' => $this->session->userdata('eventday'),
				'idPerson' => $this->session->userdata('id'),
				'buchungstyp' => $this->input->post('hidBuchungstyp'),
				'gesamtsumme' => $this->input->post('gesamtPreis_value'),
				'status' => 1,
				'created' => date("Y-m-d H:i:s"),
				'createdBy' => $this->session->userdata('id'),
			);
		} else {
			$data = array(
				'rechnungsnummer' => '',
				'idFesttag' => $this->session->userdata('eventday'),
				'idPerson' => $this->input->post('selectPerson'),
				'buchungstyp' => $this->input->post('hidBuchungstyp'),
				'gesamtsumme' => $this->input->post('gesamtPreis_value'),
				'status' => 1,
				'created' => date("Y-m-d H:i:s"),
				'createdBy' => $this->session->userdata('id'),

			);
		}

		$insert = $this->db->insert('buchung', $data);
		$order_id = $this->db->insert_id();

		$printItems = null;

		$countArticle = count($this->input->post('artikel'));
		for ($x = 0; $x < $countArticle; $x++) {
			$items = array(
				'idBuchung' => $order_id,
				'idFestartikel' => $this->input->post('id')[$x],
				'menge' => $this->input->post('menge')[$x],
				'einzelsumme' => $this->input->post('preis')[$x],
				'gesamtsumme' => $this->input->post('posPreis_value')[$x],
			);

			$this->db->insert('buchung_festartikel', $items);

			//$article = $this->model_article->getArticle($this->input->post('id')[$x]);

			$printItems[$x] = array(
				'menge' => $this->input->post('menge')[$x],
				'artikel' => $this->input->post('artikel')[$x],
				'preis' => $this->input->post('preis')[$x],
				'artikelpreis' => $this->input->post('posPreis_value')[$x],
				'gutschein' => 	$this->input->post('gutschein')[$x],
			);
		}

		//Ist es eine Kellnerbuchung dann auch die Kellnersumme anpassen 
		if ($this->input->post('hidBuchungstyp') == 2) {
			$organisation = $this->model_organisation->getData('1');
			$userdata = $this->model_users->getUserData($this->session->userdata('id'));
			$user = $userdata['vorname'] . " " . $userdata['name'];
			$waiterdata = $this->model_eventuser->getName($this->input->post('selectPerson'));
			$event = $this->model_eventday->getEventdayEventData($this->session->userdata('eventday'));

			if ($this->input->post('chkPrintReceipt')) {
				$this->model_print->printWaiterReceipt($printItems, $this->input->post('gesamtPreis_value'), $waiterdata, $organisation['name'], $user, $event, '10.0.0.40');
			}
			$this->model_eventuser->updateCash($this->input->post('selectPerson'), $this->input->post('gesamtPreis_value'));
		}

		//Ist es eine Kassenbuchung dann auch die Kassensumme anpassen 
		if ($this->input->post('hidBuchungstyp') == 3) {
			$eventcashregister = $this->model_eventcashregister->getComplete($this->input->post('selectPerson'));
			$organisation = $this->model_organisation->getData('1');
			$userdata = $this->model_users->getUserData($this->session->userdata('id'));
			$user = $userdata['vorname'] . " " . $userdata['name'];
			$event = $this->model_eventday->getEventdayEventData($this->session->userdata('eventday'));

			if ($this->input->post('chkPrint')) {
				$this->model_print->printCashregisterVoucher($printItems, $eventcashregister['name'], $organisation['name'], $user, $event, '10.0.0.40');
			}
			if ($this->input->post('chkPrintReceipt')) {
				$this->model_print->printCashregisterReceipt($printItems, $this->input->post('gesamtPreis_value'), $eventcashregister['name'], $organisation, $user, $event, '10.0.0.40');
			}
			$this->model_eventcashregister->updateCash($this->input->post('selectPerson'), $this->input->post('gesamtPreis_value'));
		}

		//Ist es eine Kundenbuchung und ein Druck gewuenscht ist 
		if ($this->input->post('hidBuchungstyp') == 4) {
			if ($this->input->post('chkPrintReceipt')) {
				//$this->model_print->printCashregisterVoucher($printItems, $eventcashregister['name'], $organisation['name'], $user, $event, '192.168.1.55');
			}
		}

		return ($order_id) ? $order_id : false;
	}

	//Anzahl der Artikel je Buchung
	public function countOrderItem($order_id)
	{
		if ($order_id) {
			// $sql = "SELECT SUM(menge) as anzahl FROM buchung_festartikel WHERE idBuchung = ?";
			$sql = "SELECT menge FROM buchung_festartikel WHERE idBuchung = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
			// $anzahl = $query->row_array();
			// return $anzahl['anzahl'];
		}
	}

	//noch anzupassen wenn noetig
	public function update($id)
	{
		if ($id) {
			$user_id = $this->session->userdata('id');
			$user_data = $this->model_users->getUserData($user_id);
			$store_id = $user_data['store_id'];
			// update the table info

			$order_data = $this->getOrdersData($id);
			$data = $this->model_tables->update($order_data['table_id'], array('available' => 1));

			if ($this->input->post('paid_status') == 1) {
				$this->model_tables->update($this->input->post('table_name'), array('available' => 1));
			} else {
				$this->model_tables->update($this->input->post('table_name'), array('available' => 2));
			}

			$data = array(
				'gross_amount' => $this->input->post('gross_amount_value'),
				'service_charge_rate' => $this->input->post('service_charge_rate'),
				'service_charge_amount' => ($this->input->post('service_charge_value') > 0) ? $this->input->post('service_charge_value') : 0,
				'vat_charge_rate' => $this->input->post('vat_charge_rate'),
				'vat_charge_amount' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
				'net_amount' => $this->input->post('net_amount_value'),
				'discount' => $this->input->post('discount'),
				'paid_status' => $this->input->post('paid_status'),
				'user_id' => $user_id,
				'table_id' => $this->input->post('table_name'),
				'store_id' => $store_id
			);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('order_items');

			$count_product = count($this->input->post('product'));
			for ($x = 0; $x < $count_product; $x++) {
				$items = array(
					'order_id' => $id,
					'product_id' => $this->input->post('product')[$x],
					'qty' => $this->input->post('qty')[$x],
					'rate' => $this->input->post('rate_value')[$x],
					'amount' => $this->input->post('amount_value')[$x],
				);
				$this->db->insert('order_items', $items);
			}

			return true;
		}
	}

	public function remove($id = NULL)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('buchung');

			$this->db->where('idBuchung', $id);
			$delete_item = $this->db->delete('buchung_festartikel');
			return ($delete && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM buchung WHERE status = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
}
