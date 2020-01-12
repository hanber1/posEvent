<?php 

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
}

class Admin_Controller extends MY_Controller
{

	var $permission = array();
	var $act_user_name;
	var $act_user_group;

	public function __construct()
	{
		parent::__construct();

		$group_data = array();
		if (empty($this->session->userdata('logged_in'))) {
			$session_data = array('logged_in' => false);
			$this->session->set_userdata($session_data);
		} else {
			$user_id = $this->session->userdata('id');
			$this->load->model('model_groups');
			$group_data = $this->model_groups->getUserGroupByUserId($user_id);
			$this->data['act_user_group'] = $group_data['bezeichnung'];

			$this->data['user_permission'] = unserialize($group_data['permission']);

			$this->load->model('model_users');
			$user_data = $this->model_users->getUserData($user_id);
			$this->data['act_user_name'] = $user_data['vorname'] . ' ' . $user_data['name'];

			$this->load->model('model_eventuser');
			if ($this->session->userdata('id') == 1) {
				$eventuserCount = $this->model_eventuser->countActive();
				$eventuser_data = $this->model_eventuser->getActiveComplete();
				$this->data['eventuser'] = $eventuser_data;
				$this->data['eventuser_count'] = $eventuserCount;
			} else {
				$eventuserCount = $this->model_eventuser->countActive($this->session->userdata('eventday'));
				$eventuser_data = $this->model_eventuser->getActiveComplete($this->session->userdata('eventday'));
				$this->data['eventuser'] = $eventuser_data;
				$this->data['eventuser_count'] = $eventuserCount;
			}


			$this->load->model('model_eventcashregister');
			if ($this->session->userdata('id') == 1) {
				$eventcashregisterCount = $this->model_eventcashregister->countActive();
				$eventcashregister_data = $this->model_eventcashregister->getActiveComplete();
				$this->data['eventcashregister_count'] = $eventcashregisterCount;
				$this->data['eventcashregister'] = $eventcashregister_data;
			} else {
				$eventcashregisterCount = $this->model_eventcashregister->countActive($this->session->userdata('eventday'));
				$eventcashregister_data = $this->model_eventcashregister->getActiveComplete($this->session->userdata('eventday'));
				$this->data['eventcashregister_count'] = $eventcashregisterCount;
				$this->data['eventcashregister'] = $eventcashregister_data;
			}

			$this->load->model('model_organisation');
			$organisation_data = $this->model_organisation->getData(1);
			$this->data['organisation'] = $organisation_data['name'];

			$this->load->model('model_eventday');
			$eventday_data = $this->model_eventday->getEventdayEventData($this->session->userdata('eventday'));
			$this->data['eventdayEventData'] = $eventday_data;

			$this->permission = unserialize($group_data['permission']);
			$this->act_user_name = $this->data['act_user_name'];
		}
	}

	public function logged_in()
	{
		$session_data = $this->session->userdata();
		if ($session_data['logged_in'] == true) {
			redirect('dashboard', 'refresh');
		}
	}

	public function not_logged_in()
	{
		$session_data = $this->session->userdata();
		if ($session_data['logged_in'] == false) {
			redirect('auth/login', 'refresh');
		}
	}

	public function render_template($page = null, $data = array())
	{

		$this->load->view('templates/header', $data);
		$this->load->view('templates/header_menu', $data);
		$this->load->view('templates/side_menubar', $data);
		$this->load->view($page, $data);
		$this->load->view('templates/footer', $data);
	}

	public function render_pos_template($page = null, $data = array())
	{

		$this->load->view('templates/header_pos', $data);
		//$this->load->view('templates/header_menu_pos', $data);
		//$this->load->view('templates/side_menubar', $data);
		$this->load->view($page, $data);
		//$this->load->view('templates/footer', $data);
	}

	public function company_currency()
	{
		$this->load->model('model_organisation');
		$company_currency = $this->model_organisation->getData(1);
		$currencies = $this->currency();

		$currency = '';
		foreach ($currencies as $key => $value) {
			if ($key == $company_currency['waehrung']) {
				$currency = $value;
			}
		}

		return $currency;
	}


	public function currency()
	{
		return $currency_symbols = array(
			'AED' => '&#1583;.&#1573;', // ?
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;', // ?
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;', // ?
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;', // ?
			'BIF' => '&#70;&#66;&#117;', // ?
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTN' => '&#78;&#117;&#46;', // ?
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;', // ?
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;', // ?
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;', // ?
			'EGP' => '&#163;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;', // ?
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;', // ?
			'GNF' => '&#70;&#71;', // ?
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;', // ?
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;', // ?
			'IRR' => '&#65020;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;', // ?
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;', // ?
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;', // ?
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;', // ?
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;', // ?
			'LTL' => '&#76;&#116;',
			'LVL' => '&#76;&#115;',
			'LYD' => '&#1604;.&#1583;', // ?
			'MAD' => '&#1583;.&#1605;.', //?
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;', // ?
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;', // ?
			'MRO' => '&#85;&#77;', // ?
			'MUR' => '&#8360;', // ?
			'MVR' => '.&#1923;', // ?
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;', // ?
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;', // ?
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;', // ?
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'STD' => '&#68;&#98;', // ?
			'SVC' => '&#36;',
			'SYP' => '&#163;',
			'SZL' => '&#76;', // ?
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;', // ?
			'ZWL' => '&#90;&#36;',
		);
	}
}

