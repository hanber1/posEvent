<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();


		$this->data['page_title'] = 'Dashboard';
		
		//$this->load->model('model_products');
		//$this->load->model('model_orders');
		$this->load->model('model_eventuser');
		$this->load->model('model_event');
		$this->load->model('model_customer');
		$this->load->model('model_order');
	}

	public function index()
	{

		$this->data['total_sum'] = $this->model_order->getSumEventday($this->session->userdata('eventday'));
		//$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		$this->data['total_users'] = $this->model_eventuser->countActive($this->session->userdata('eventday'));
		$this->data['total_event'] = $this->model_event->countTotal();
		$this->data['total_customer'] = $this->model_customer->countTotal();

		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;

		$this->data['is_admin'] = $is_admin;
		$this->render_template('dashboard', $this->data);
	}
}