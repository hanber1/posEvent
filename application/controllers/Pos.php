<?php 

class Pos extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();


		$this->data['page_title'] = 'Verkauf';
		
		//$this->load->model('model_products');
		//$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_event');
		$this->load->model('model_customer');
		$this->load->model('model_eventarticle');
		$this->load->model('model_category');
		$this->load->model('model_order');
		$this->load->model('model_print');		

	}

	public function index()
	{

		//$this->data['total_products'] = $this->model_products->countTotalProducts();
		//$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_event'] = $this->model_event->countTotal();
		$this->data['total_customer'] = $this->model_customer->countTotal();

		$this->data['category'] = $this->model_category->getActive();
		$this->data['article'] = $this->model_eventarticle->getArticlePos($this->session->userdata('eventday'));




		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;

		$this->data['is_admin'] = $is_admin;
		$this->render_pos_template('pos/index', $this->data);
	}

	public function create()
	{

		//$this->data['page_title'] = 'Add Order';

		$this->form_validation->set_rules('selectPerson', 'Kellnernummer', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('artikel[]', 'Artikelname', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$order_id = $this->model_order->create();
        	
        	if($order_id) {
        		$this->session->set_flashdata('success', 'Successfully created');
				redirect('pos/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('pos/', 'refresh');
        	}
        }
        else {
            // false case
            // $this->data['table_data'] = $this->model_tables->getActiveTable();
        	// $company = $this->model_company->getCompanyData(1);
        	// $this->data['company_data'] = $company;
        	// $this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
        	// $this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;

        	// $this->data['products'] = $this->model_products->getActiveProductData();      	
            // $this->render_template('orders/create', $this->data);

            redirect('pos/', 'refresh');
        }	
	}

}