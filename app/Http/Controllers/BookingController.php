<?php

namespace App\Http\Controllers;
use Spatie\GoogleCalendar\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;

class BookingController extends Controller
{
    public function showbooking() 
    {
       return view('booking.index');
    }

    public function store(Request $request) 
    {

               $request->session()->put('fName',$request['firstName']);
               $request->session()->put('lName',$request['lastName']);
               $request->session()->put('email',$request['email']);
               $request->session()->put('phoneNumber',$request['phoneNumber']);
               $request->session()->put('researchTopic',$request['researchTopic']);
               $request->session()->put('discipline',$request['discipline']);
               $request->session()->put('levelofResearch',$request['levelofResearch']);
               $request->session()->put('problemDescription',$request['problemDescription']);
               $request->session()->put('service',$request['service']);
               $request->session()->put('bookingDate', 200);
               return redirect()->route('booking.pay'); 
    }


    public function showpaymentpage() 
    {
       return view('booking.pay');
    }

    
    public function processPayament(Request $request) 
    {
   
        
// $data = json_decode(file_get_contents('php://input'),true);
// $email=$data["email"];
// $reference=$data["reference"];
// $amount=$data["amount"];


// $request->input('user.0.name');
// $request->input('user.1.name');

$email=$request->input('email');
$reference=$request->input('reference');
$amount=$request->input('amount');
$currency="GHS";

//$data = json_decode($request->json()->all(),true);

// $email="amparbengmaxwell@gmail.com";
// $reference=2079944350;
// $amount=250;
// $currency="GHS";






// if(empty($email) || empty($reference) || empty($amount)  ){
// return;
// }

// if(!is_numeric($amount)){
// return;
// }

        if($currency=="GHS"){
            $paystack_sk_key="sk_test_ca2abe830a67bb4bc8de18604496abb694215dc0";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/$reference");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $headers = array();
            $headers[] = 'Authorization: Bearer '.$paystack_sk_key.'';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
             curl_close($ch);
              $obj = json_encode($result);
            
             $result = json_decode($result);
             $apistatus=$result->status;   // Output: 65
             $apisverificationtatus= $result->data->status;   // Output: 80
             $apireference=$result->data->reference;    // Output: 78
             $apiamount= $result->data->amount;
             $apicurrency=$result->data->currency;
             $apifees= $result->data->fees;
        
             
           if($apistatus==1 && $apireference== $reference && $apisverificationtatus=="success"){



          



               $booking= new Booking();
               $booking->firstName= $request->session()->get('fName');
               $booking->LastName= $request->session()->get('lName');
               $booking->email= $request->session()->get('email');
               $booking->phoneNumber= $request->session()->get('phoneNumber');
               $booking->researchTopic= $request->session()->get('researchTopic');
               $booking->discipline= $request->session()->get('discipline');
               $booking->levelofResearch= $request->session()->get('levelofResearch');
               $booking->problemDescription= $request->session()->get('problemDescription');
               $booking->service= $request->session()->get('service');
               $booking->bookingDate="12/12/12"; //$request->session()->get('bookingDate');//$request['bookingDate'];
               $booking->amountPayed= 200;
               $booking->bookingStatus= "pending";
              $booking->save();


              $request->session()->flush();

            
               return redirect()->route('booking.index')
               ->withSuccess(__('Post created successfully.'));


        //    $myfile = fopen("logs.txt", "a") or die("Unable to open file!");
        //    $txt =  $api;
        //    fwrite($myfile, "\n". $txt);
        //    fclose($myfile);
    
            }
        
           
        }
       
    }


    public function testing(){


$events = Event::get();
$events[0]->startDate;
$events[0]->startDateTime;
$events[0]->endDate;
echo $events[0]->endDateTime;


    }

    


   

    
}
