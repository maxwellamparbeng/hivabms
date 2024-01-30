<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
//use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;


//Includes WebClientPrint classes
include_once(app_path() . '\WebClientPrint\WebClientPrint.php');
use Neodynamic\SDK\Web\WebClientPrint;




class PrintReceiptController extends Controller
{
    public function index(){
        
        $profile = CapabilityProfile::load("simple");
        $connector = new WindowsPrintConnector("POS-58");
        $printer = new Printer($connector, $profile);
        $printer -> text("Hello World!\n");
$printer -> cut();
$printer -> close();

    }

    public function printESCPOS(){


        $wcpScript = WebClientPrint::createScript( action('PrintESCPOSController@printCommands'), Session::getId());    

        return view('posprinter.printESCPOS', ['wcpScript' => $wcpScript]);
    }
    
}
