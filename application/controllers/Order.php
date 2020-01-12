<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order extends Admin_Controller
{
	var $currency_code = '';

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Bestellung';

		$this->load->model('model_order');
		$this->load->model('model_eventarticle');
		$this->load->model('model_eventuser');
		$this->load->model('model_eventcashregister');
		$this->load->model('model_customer');
		$this->load->model('model_eventday');
		$this->load->model('model_users');
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		// if(!in_array('viewOrder', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }

		$this->data['page_title'] = 'Bestellungen verwalten';
		$this->render_template('order/index', $this->data);
	}

	/*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
	public function fetchData()
	{
		// if(!in_array('viewOrder', $this->permission)) {
		//     redirect('dashboard', 'refresh');
		// }

		$result = array('data' => array());

		if ($this->session->userdata('id') == 1) {
			$data = $this->model_order->getData();
		} else {
			$data = $this->model_order->getDataEventday($this->session->userdata('eventday'));
		}

		foreach ($data as $key => $value) {

			$eventday = $this->model_eventday->getEventdayEventData($value['idFesttag']);

			$personName = NULL;
			$buchungstyp = NULL;

			//Barverkauf
			if ($value['buchungstyp'] === '1') {
				$buchungstyp = 'Barverkauf';
				$temp = $this->model_users->getComplete($value['idPerson']);
				$personName['name'] = $temp['name'];
			}
			//Kellner
			elseif ($value['buchungstyp'] === '2') {
				$buchungstyp = 'Kellner';
				$temp = $this->model_eventuser->getComplete($value['idPerson']);
				$personName['name'] = $temp['name'];
			}
			//Kassa
			elseif ($value['buchungstyp'] === '3') {
				$buchungstyp = 'Kassa';
				$temp = $this->model_eventcashregister->getComplete($value['idPerson']);
				$personName['name'] = $temp['name'];
			}
			//Kunde
			elseif ($value['buchungstyp'] === '4') {
				$buchungstyp = 'Kunde';
				$temp = $this->model_customer->getData($value['idPerson']);
				$personName['name'] = $temp['name'];
			}

			$count_total_item = $this->model_order->countOrderItem($value['id']);
			//$date = date('d-m-Y', $value['created']);

			//$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if (in_array('viewOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-primary" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal" title="Ansehen"><i class="fa fa-eye"></i></button>';
			}

			if (in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-danger" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal" title="Löschen"><i class="fa fa-trash"></i></button>';
			}

			if ($value['status'] == 1) {
				$paid_status = '<span class="label label-success">bezahlt</span>';
			} else {
				$paid_status = '<span class="label label-warning">offen</span>';
			}

			$result['data'][$key] = array(
				$value['created'],
				$eventday,
				$personName['name'],
				$buchungstyp,
				$count_total_item,
				$value['gesamtsumme'],
				$paid_status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{

		$this->form_validation->set_rules('artikel[]', 'Artikelname', 'trim|required');


		if ($this->form_validation->run() == TRUE) {

			$order_id = $this->model_order->create();

			if ($order_id) {
				$this->session->set_flashdata('success', 'Buchung erstellt');
				redirect('pos/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Fehler!!');
				redirect('pos/', 'refresh');
			}
		}
	}

	public function fetchDataDetail($order_id)
	{

		//$orderData = $this->model_order->getData($order_id);
		
		$data = $this->model_order->getOrderItemData($order_id);
		$result = array('data' => array());

		foreach ($data as $key => $value) {

			$erstellt = $value['name'] ." ". $value['vorname'];
			$article = $value['einheit'] ." ". $value['artikel'];

			$result['data'][$key] = array(
				$erstellt,
				$value['erstellt'],
				$value['buchungssumme'],
				$article,
				$value['menge'],
				$value['gesamtsumme'],
			);
			
		}
		//$result['data']['gesamt'] = "25.30";
		echo json_encode($result);
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		// if(!in_array('deleteOrder', $this->permission)) {
		//         redirect('dashboard', 'refresh');
		//     }

		$order_id = $this->input->post('order_id');

		$response = array();
		if ($order_id) {
			$delete = $this->model_order->remove($order_id);
			if ($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Bestellung erfolgreich gelöscht";
			} else {
				$response['success'] = false;
				$response['messages'] = "Beim Löschen der Bestellung ist ein Fehler in der Datenbank aufgetreten";
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Fehler!! Bitte die Seite neu laden!!";
		}

		echo json_encode($response);
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv($id)
	{
		if (!in_array('viewOrder', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
			$store_data = $this->model_stores->getStoresData($order_data['store_id']);

			$order_date = date('d/m/Y', $order_data['date_time']);
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$table_data = $this->model_tables->getTableData($order_data['table_id']);

			if ($order_data['discount'] > 0) {
				$discount = $this->currency_code . ' ' . $order_data['discount'];
			} else {
				$discount = '0';
			}


			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>Invoice</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="' . base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') . '">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="' . base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') . '">
			  <link rel="stylesheet" href="' . base_url('assets/dist/css/AdminLTE.min.css') . '">
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header">
			          ' . $company_info['company_name'] . '
			          <small class="pull-right">Date: ' . $order_date . '</small>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      
			      <div class="col-sm-4 invoice-col">
			        <b>Bill ID: </b> ' . $order_data['bill_no'] . '<br>
			        <b>Store Name: </b> ' . $store_data['name'] . '<br>
			        <b>Table name: </b> ' . $table_data['table_name'] . '<br>
			        <b>Total items: </b> ' . count($orders_items) . '<br><br>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Product name</th>
			            <th>Price</th>
			            <th>Qty</th>
			            <th>Amount</th>
			          </tr>
			          </thead>
			          <tbody>';

			foreach ($orders_items as $k => $v) {

				$product_data = $this->model_products->getProductData($v['product_id']);

				$html .= '<tr>
				            <td>' . $product_data['name'] . '</td>
				            <td>' . $this->currency_code . ' ' . $v['rate'] . '</td>
				            <td>' . $v['qty'] . '</td>
				            <td>' . $this->currency_code . ' ' . $v['amount'] . '</td>
			          	</tr>';
			}

			$html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			      
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			            <tr>
			              <th style="width:50%">Gross Amount:</th>
			              <td>' . $this->currency_code . ' ' . $order_data['gross_amount'] . '</td>
			            </tr>';

			if ($order_data['service_charge_amount'] > 0) {
				$html .= '<tr>
				              <th>Service Charge (' . $order_data['service_charge_rate'] . '%)</th>
				              <td>' . $this->currency_code . ' ' . $order_data['service_charge_amount'] . '</td>
				            </tr>';
			}

			if ($order_data['vat_charge_amount'] > 0) {
				$html .= '<tr>
				              <th>Vat Charge (' . $order_data['vat_charge_rate'] . '%)</th>
				              <td>' . $this->currency_code . ' ' . $order_data['vat_charge_amount'] . '</td>
				            </tr>';
			}


			$html .= ' <tr>
			              <th>Discount:</th>
			              <td>' . $discount . '</td>
			            </tr>
			            <tr>
			              <th>Net Amount:</th>
			              <td>' . $this->currency_code . ' ' . $order_data['net_amount'] . '</td>
			            </tr>
			            <tr>
			              <th>Paid Status:</th>
			              <td>' . $paid_status . '</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			echo $html;
		}
	}
}
