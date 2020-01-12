<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// IMPORTANT - Replace the following line with your path to the escpos-php autoload script
//require_once __DIR__ . '\autoload.php';
require_once APPPATH . 'third_party/escpos_php/autoload.php';

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
//use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

class ReceiptPrint
{

  private $CI;
  private $connector;
  private $printer;

  // TODO: printer settings
  // Make this configurable by printer (32 or 48 probably)
  private $printer_width = 48;

  function __construct()
  {
    $this->CI = &get_instance(); // This allows you to call models or other CI objects with $this->CI->... 
  }

  function connect($ip_address, $port)
  {
    $this->connector = new NetworkPrintConnector($ip_address, $port);
    $this->printer = new Printer($this->connector);
  }

  private function check_connection()
  {
    if (!$this->connector or !$this->printer or !is_a($this->printer, 'Mike42\Escpos\Printer')) {
      throw new Exception("Tried to create receipt without being connected to a printer.");
    }
  }

  public function close_after_exception()
  {
    if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
      $this->printer->close();
    }
    $this->connector = null;
    $this->printer = null;
    $this->emc_printer = null;
  }

  // Calls printer->text and adds new line
  private function add_line($text = "", $should_wordwrap = true)
  {
    $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
    $this->printer->text($text . "\n");
  }

  private function add_article($amount = "", $article = "")
  {
    //$line = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
    $line = $amount . " x " . wordwrap($article, $this->printer_width);
    $this->printer->text($line . "\n");
  }

  private function add_article_price($amount = "", $article = "", $piceprice = "", $price = "")
  {
    //$line = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
    $line1 = wordwrap($article, $this->printer_width) . "\n";

    $line21 = $amount . " x ". $piceprice . " = " . $price;

    $length = strlen($line21);
    $freesigns = "";
    for ($i=0; $i < ($this->printer_width - 4 - $length); $i++) { 
      $freesigns = $freesigns . " ";
    }
    $line2 = $freesigns . $line21;
    $line = $line1 . $line2;
    $this->printer->text($line . "\n");
  }

  private function add_summ($summ = "")
  {
    //$line = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
    $line1 = "Gesamtsumme : € " . $summ;

    $length = strlen($line1);
    $freesigns = "";
    for ($i=0; $i < ($this->printer_width - 2 - $length); $i++) { 
      $freesigns = $freesigns . " ";
    }
    $line = $freesigns . $line1;
    $this->printer->text($line . "\n");
  }

  private function add_partingLine()
  {
    for ($i = 0; $i < $this->printer_width-4; $i++) {
      $this->printer->text("-");
    }
    $this->printer->text("\n");
  }

  public function printVoucher($item = array(), $cashregister = "", $category = "", $organisation = "", $user = "", $event = "", $printerIP)
  {

    $this->connect($printerIP, 9100);
    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line($organisation);
    $this->printer->selectPrintMode();
    $this->add_line(); // blank line
    $this->add_line($event);
    $this->add_line(); // blank line
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line($category);
    $this->printer->selectPrintMode();
    $this->add_line(); // blank line
    $this->printer->setJustification(Printer::JUSTIFY_LEFT);
    $this->printer->setPrintLeftMargin(40);

    foreach ($item as $key => $value) {
      $this->add_article($item[$key]['menge'], $item[$key]['artikel']);
    }
    $this->add_partingLine(); // blank line
    //$this->printer->setJustification(Printer::JUSTIFY_CENTER);
    //$this->printer->setFont(Printer::FONT_B);
    //$this->printer->text("Es bediente Sie: ");
    //$this->printer->setFont(Printer::FONT_A);
    $this->add_line("Es bediente Sie: " . $user);
    // $this->printer->setFont(Printer::FONT_B);
    // $this->printer->text("Gebucht bei:     ");
    // $this->printer->setFont(Printer::FONT_A);
    $this->add_line("Gebucht bei:     " . $cashregister);
    $this->add_line(); // blank line
    // $this->printer->setFont(Printer::FONT_B);
    // $this->printer->text("Zeitpunkt:       ");
    // $this->printer->setFont(Printer::FONT_A);
    $this->add_line("Zeitpunkt:       " . date('Y-m-d H:i:s'));
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();
  }

  public function printWaiterReicept($item = array(), $summ = "", $waiter = "", $organisation = "", $user = "", $event = "", $printerIP)
  {

    $this->connect($printerIP, 9100);
    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line($organisation);
    $this->printer->selectPrintMode();
    $this->add_line(); // blank line
    $this->add_line($event);
    $this->add_line(); // blank line
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("Kellnerbeleg");
    $this->printer->selectPrintMode();
    $this->add_line(); // blank line
    $this->printer->setJustification(Printer::JUSTIFY_LEFT);
    $this->printer->setPrintLeftMargin(40);

    foreach ($item as $key => $value) {
      $this->add_article_price($item[$key]['menge'], $item[$key]['artikel'], $item[$key]['preis'], $item[$key]['artikelpreis']);
    }

    $this->add_partingLine();
   // $this->printer->setJustification(Printer::JUSTIFY_RIGHT);

    $this->add_summ($summ);

    $this->add_partingLine();
    //$this->printer->setJustification(Printer::JUSTIFY_CENTER);
    //$this->printer->setFont(Printer::FONT_B);
    //$this->printer->text("Es bediente Sie: ");
    //$this->printer->setFont(Printer::FONT_A);
    $this->add_line("Es bediente Sie: " . $waiter);
    // $this->printer->setFont(Printer::FONT_B);
    // $this->printer->text("Gebucht bei:     ");
    // $this->printer->setFont(Printer::FONT_A);
    $this->add_line("Gebucht von:     " . $user);
    $this->add_line(); // blank line
    // $this->printer->setFont(Printer::FONT_B);
    // $this->printer->text("Zeitpunkt:       ");
    // $this->printer->setFont(Printer::FONT_A);
    $this->add_line("Zeitpunkt:       " . date('Y-m-d H:i:s'));
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();
  }

  public function printCashRegisterReicept($item = array(), $summ = "", $cashregister = "", $organisation = array(), $user = "", $event = "", $printerIP)
  {

    $this->connect($printerIP, 9100);
    $this->check_connection();
    $this->printer->setJustification(Printer::JUSTIFY_CENTER);
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line($organisation['name']);
    $this->printer->selectPrintMode();
    $this->add_line($organisation['addresse']);
    $this->add_line(); // blank line
    $this->add_line($event);
    $this->add_line(); // blank line
    $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $this->add_line("Kassenbeleg");
    $this->printer->selectPrintMode();
    $this->add_line(); // blank line
    $this->printer->setJustification(Printer::JUSTIFY_LEFT);
    $this->printer->setPrintLeftMargin(40);

    foreach ($item as $key => $value) {
      $this->add_article_price($item[$key]['menge'], $item[$key]['artikel'], $item[$key]['preis'], $item[$key]['artikelpreis']);
    }

    $this->add_partingLine();
   // $this->printer->setJustification(Printer::JUSTIFY_RIGHT);

    $this->add_summ($summ);

    $this->add_partingLine();
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    $this->add_line(); // blank line
    //$this->printer->setJustification(Printer::JUSTIFY_CENTER);
    //$this->printer->setFont(Printer::FONT_B);
    //$this->printer->text("Es bediente Sie: ");
    //$this->printer->setFont(Printer::FONT_A);
    $this->add_line("Es bediente Sie: " . $user);
    // $this->printer->setFont(Printer::FONT_B);
    // $this->printer->text("Gebucht bei:     ");
    // $this->printer->setFont(Printer::FONT_A);
    $this->add_line("Gebucht bei:     " . $cashregister);
    $this->add_line(); // blank line
    // $this->printer->setFont(Printer::FONT_B);
    // $this->printer->text("Zeitpunkt:       ");
    // $this->printer->setFont(Printer::FONT_A);
    $this->add_line("Zeitpunkt:       " . date('Y-m-d H:i:s'));
    $this->printer->cut(Printer::CUT_PARTIAL);
    $this->printer->close();
  }


}
/* A wrapper to do organise item names & prices into columns */
class item
{
  private $amount;
  private $article;
  private $price;
  private $currentSign;

  public function __construct($amount = '', $article = '', $price = "", $currentSign = false)
  {
    $this->amount = $amount;
    $this->article = $article;
    $this->currentSign = $currentSign;
    $this->price = $price;
  }

  public function __toString()
  {
    $rightCols = 10;
    $leftCols = 38;
    if ($this->currentSign) {
      $leftCols = $leftCols / 2 - $rightCols / 2;
    }
    $left = str_pad($this->amount, $leftCols);

    $sign = ($this->currentSign ? '€ ' : '');
    $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
    //$right = str_pad($this -> article, $rightCols, ' ', STR_PAD_LEFT);
    return "$left  $right\n";
  }
}
