<?php

class Model_print extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

        $this->load->library('ReceiptPrint');
        $this->load->model('Model_eventarticle');
        $this->load->model('Model_users');
        $this->load->model('Model_cashregister');
        $this->load->model('Model_customer');


    }
    
	public function printCashregisterVoucher($items = array(), $cashregister = null, $organisation = null, $user = null, $event = null, $printerIP = null)
	{
        
          $itemsVoucher_1 = array();
          $itemsVoucher_2 = array();
          $voucher1 = 0;
          $voucher2 = 0;

          $countItems = count($items);

          for ($x = 0; $x < $countItems; $x++) {
            if ($items[$x]['gutschein'] === '1') {
              $voucher1 += 1;
              $itemsVoucher_1[$voucher1] = array(
                'menge' => $items[$x]['menge'],
                'artikel' => $items[$x]['artikel'],
              );
            }
            elseif ($items[$x]['gutschein'] === '2') {
              $voucher2 += 1;
              $itemsVoucher_2[$voucher2] = array(
                'menge' => $items[$x]['menge'],
                'artikel' => $items[$x]['artikel'],
              );
            }
          }
          try {
            //$this->receiptprint->connect($printerIP, 9100);
            if ($itemsVoucher_1 && !$itemsVoucher_2) {
              $this->receiptprint->printVoucher($itemsVoucher_1, $cashregister, 'Getränke', $organisation, $user, $event, $printerIP);
            }
            if ($itemsVoucher_2 && !$itemsVoucher_1) {
              $this->receiptprint->printVoucher($itemsVoucher_2, $cashregister, 'Speisen', $organisation, $user, $event, $printerIP);
            }
            if ($itemsVoucher_1 && $itemsVoucher_2) {
              $this->receiptprint->printVoucher($itemsVoucher_1, $cashregister, 'Getränke', $organisation, $user, $event, $printerIP);
              $this->receiptprint->printVoucher($itemsVoucher_2, $cashregister, 'Speisen', $organisation, $user, $event, $printerIP);
          }

          } catch (Exception $e) {
            log_message("error", "Error: Could not print. Message ".$e->getMessage());
            $this->receiptprint->close_after_exception();
          }
	}

  public function printCashregisterReceipt($items = null, $sum = null, $cashregister = null, $organisation = null, $user = null, $event = null, $printerIP = null)
	{
        try {
          $this->receiptprint->printCashRegisterReicept($items, $sum, $cashregister, $organisation, $user, $event, $printerIP);
          } catch (Exception $e) {
            log_message("error", "Error: Could not print. Message ".$e->getMessage());
            $this->receiptprint->close_after_exception();
          }
	}

	public function printWaiterReceipt($items = null, $sum = null, $waiter = null, $organisation = null, $user = null, $event = null, $printerIP = null)
	{
        try {
          $this->receiptprint->printWaiterReicept($items, $sum, $waiter, $organisation, $user, $event, $printerIP);
          } catch (Exception $e) {
            log_message("error", "Error: Could not print. Message ".$e->getMessage());
            $this->receiptprint->close_after_exception();
          }
	}

	public function printCustomerReceipt($items = null, $customer = null, $organisation = null, $user = null, $event = null, $printerIP = null)
	{
        try {


          $this->receiptprint->connect($printerIP, 9100);
            //$this->receiptprint->print_test_receipt($text, $category, $organisation, $user);
          } catch (Exception $e) {
            log_message("error", "Error: Could not print. Message ".$e->getMessage());
            $this->receiptprint->close_after_exception();
          }
	}

}