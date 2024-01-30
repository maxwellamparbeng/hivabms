<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\CampaignReport;
use Illuminate\Support\Facades\DB;
use SweetAlert;
use App\Models\Product;
use App\Models\ReceiptNote;
use App\Models\Vat;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\ProductsCategory;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\Branch;
use App\Models\User;
use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Collection;
use Rap2hpoutre\FastExcel\FastExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportSales;
use App\Exports\ExportInventory;
use App\Exports\ExportInventoryLog;
use App\Models\InventoryLog;
use Response;


class ApiController extends Controller
{

    public function clientinfo(Request $request){
       
        $validatedData = $request->validate([
            'searchdata' => 'required|numeric',
        ]);

        $cartdata =DB::table('transactions')->where('transactions.phone',request('searchdata'))->limit(1)->get();
        $count=count($cartdata);

        if($count==1){

            foreach ($cartdata as $clientInfo) {
            $name = $clientInfo->customer;
            $address = $clientInfo->address;
            $phone = $clientInfo->phone;
            $email = $clientInfo->email;


            }


            $data=[
                "Status" =>200,
                "Message" =>"Client found",
                "fullname" =>$name,
                "address" =>$address,
                "phone" =>$phone,
                "email" =>$email,
                 ];

             return Response::json($data);
             return;

        }


        $cartdata =DB::table('clients')->where('clients.phoneNumber',request('searchdata'))->limit(1)->get();
        $count=count($cartdata);
        if($count==1){
            foreach ($cartdata as $clientInfo) {
                $name = $clientInfo->fullname;
                $address = "";
                $phone = $clientInfo->phoneNumber;
                $email = $clientInfo->emailAddress;
    
    
                }

            $data=[
                "Status" =>200,
                "Message" =>"Client found",
                "fullname" =>$name,
                "address" =>$address,
                "phone" =>$phone,
                "email" =>$email,
                 ];

            return Response::json($data);
        return;
        }


        else{

            $data=[
                "Status" =>100,
                "Message" =>"Client not found",
                 ];

            return Response::json($data);
           return;

        }



        
      
      
        }



}
