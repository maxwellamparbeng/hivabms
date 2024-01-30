<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CampaignReport;
Use \Carbon\Carbon;
use Illuminate\Support\Str;


class MessengerController extends Controller
{
    
public function sendsms(Company $companyId){
  $companyId = getusercompanyId();
$userInfo = Auth::user()->id;
$userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
//$records =DB::table('clients')->join('contact_group','contact_group.contactGroupId', '=', 'clients.contactgroupId')->where('clients.companyId',$companyId)->get(); 
$groups = DB::table('contact_group')->where('companyId',$companyId)->get();

return view('communication.sendsms',[
            'user' => $userdetails,
            'contactgroups'=>$groups
]);
    
    
    }

    public function executesms(Request $request){

        $validatedData = $request->validate([
            'campaign_type' => 'required',
            'message' => 'required',
            'smsApiusername' => 'required',
            'smsApikey' => 'required',
            'senderName' => 'required'
        ]);
    
    $userInfo = Auth::user()->id;
    $companyId = getusercompanyId();  
    $campaign_type = request('campaign_type');
    $senderName = request('senderName');
    $mobile_numbers = request('mobile_numbers');
    $message = request('message');
    $smsapikey = request('smsApikey');
    $smsapiusername = request('smsApiusername');
    
    $contact_arr = array();

    if($campaign_type=='Personalized'){
   
   $numbers=$array = preg_split('/\r\n|\r|\n/',$mobile_numbers);
   $arrlength = count($numbers);
   for($x = 0; $x < $arrlength; $x++) {
    $new_contact=$numbers[$x];
    $new_number=trim($new_contact);

    if (substr($new_number, 0, 3) == '233' || strlen($new_number) == 10 ) {
   
    array_push($contact_arr,$new_number);

   }

     }

     $result = sendsms($contact_arr , $message , $smsapiusername , $smsapikey , $senderName);
     $status= $result->status;
    

    if($status=="HSHK_OK"){
       
       $credit_used=$result->credit_used;
       $total_sent=$result->total_sent;
       $numbers_sent=$result->numbers_sent;
       $mytime = Carbon::now();
       $uuid = Str::uuid()->toString();
       $report = new CampaignReport();
       $report->campaignType = 'Personalized';
       $report->category = 'Sms';
       $report->totalSent = $total_sent;
       $report->status = 'Sent';
       $report->campaignId = $uuid;
       $report->dateCreated =  $mytime->toDateTimeString();
       $report->companyId =$companyId;
       $report->apiResponse='max';
       $report->message=$message;
       $report->save();
       alert()->success('Sms sent succesfully', 'Success!');
       return redirect('/smsreport');


    }





    }
    
    if($campaign_type=='Customers'){
        $userInfo = Auth::user()->id;

        $companyId = getusercompanyId();    
       

        $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
        $comapanyId=$userdetails->companyId;
        $specialities = Client::where('companyId',$comapanyId)->get();

        $counter=count($specialities);
        if($counter==0){
          alert()->error('Contact Group is empty or cannot be found', 'Error!');
          return redirect('/sendsms');
        }

        foreach ($specialities as $user) {
           
            array_push($contact_arr,$user->phoneNumber);
           
        }
        $result = sendsms($contact_arr , $message , $smsapiusername , $smsapikey , $senderName);
         $status= $result->status;
        

        if($status=="HSHK_OK"){
           
           $credit_used=$result->credit_used;
           $total_sent=$result->total_sent;
           $numbers_sent=$result->numbers_sent;
           $mytime = Carbon::now();
           $uuid = Str::uuid()->toString();
           $report = new CampaignReport();
           $report->campaignType = 'Customers';
           $report->category = 'Sms';
           $report->totalSent = $total_sent;
           $report->status = 'Sent';
           $report->campaignId = $uuid;
           $report->dateCreated =  $mytime->toDateTimeString();
           $report->companyId =$companyId;
           $report->apiResponse='max';
           $report->message=$message;
           $report->save();
           alert()->success('Sms sent succesfully', 'Success!');
           return redirect('/smsreport');


        }

        
    
}





if($campaign_type=='Employees'){
    $userInfo = Auth::user()->id;
    $companyId = getusercompanyId();    
    $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
    $comapanyId=$userdetails->companyId;
    $specialities = Employee::where('companyId',$comapanyId)->get();

    $counter=count($specialities);
    if($counter==0){
      alert()->error('Contact Group is empty or cannot be found', 'Error!');
      return redirect('/sendsms');
    }

    foreach ($specialities as $user) {
        array_push($contact_arr,$user->phoneNumber);
    }
    $result = sendsms($contact_arr , $message , $smsapiusername , $smsapikey , $senderName);
     $status= $result->status;
  
    if($status=="HSHK_OK"){
       $credit_used=$result->credit_used;
       $total_sent=$result->total_sent;
       $numbers_sent=$result->numbers_sent;
       $mytime = Carbon::now();
       $uuid = Str::uuid()->toString();
       $report = new CampaignReport();
       $report->campaignType = 'Employees';
       $report->category = 'Sms';
       $report->totalSent = $total_sent;
       $report->status = 'Sent';
       $report->campaignId = $uuid;
       $report->dateCreated =  $mytime->toDateTimeString();
       $report->companyId =$companyId;
       $report->apiResponse='max';
       $report->message=$message;
       $report->save();
       alert()->success('Sms sent succesfully', 'Success!');
       return redirect('/smsreport');
       
    }

}


else{
  $userInfo = Auth::user()->id;
  $companyId = getusercompanyId();    
  $specialities =DB::table('clients')->where('clients.companyId',$companyId)->where('clients.contactgroupId',$campaign_type)->get();
  $counter=count($specialities);
  if($counter==0){
    alert()->error('Contact Group is empty or cannot be found', 'Error!');
    return redirect('/sendsms');
  }

  foreach ($specialities as $user) {
  array_push($contact_arr,$user->phoneNumber);
  }
  $result = sendsms($contact_arr , $message , $smsapiusername , $smsapikey , $senderName);
   $status= $result->status;
  if($status=="HSHK_OK"){
     
     $credit_used=$result->credit_used;
     $total_sent=$result->total_sent;
     $numbers_sent=$result->numbers_sent;
     $mytime = Carbon::now();
     $uuid = Str::uuid()->toString();
     $report = new CampaignReport();
     $report->campaignType = 'Contact Group -'.$campaign_type;
     $report->category = 'Sms';
     $report->totalSent = $total_sent;
     $report->status = 'Sent';
     $report->campaignId = $uuid;
     $report->dateCreated =  $mytime->toDateTimeString();
     $report->companyId =$companyId;
     $report->apiResponse='.';
     $report->message=$message;
     $report->save();
     alert()->success('Sms sent succesfully', 'Success!');
     return redirect('/smsreport');
     
    
     

  }






}




    }






    public function smsreport() 
    {
      $companyId = getusercompanyId();    
      $userInfo = Auth::user()->id;
      $clients = DB::table('campaignreport')->where('campaignreport.companyId',$companyId)->orderBy('dateCreated','desc')->get(); 
      return view('communication.sms-report')->with('records',$clients);
    }


    public function buysmsbundle() 
    {
    $data= getsmscredentials();
    $apiusername=$data[0];
    $apikey=$data[1];

    $data=hivatxtlogin($apikey,$apiusername);
    $status= $data->status;

    if($status==200){
    $url ="https://hivatxt.com/sms/index.php/user/verifyloginviaapi" ;
    echo'
    <!DOCTYPE html>
    <html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    /* Center the loader */
    #loader {
         position: absolute;
         left: 50%;
         top: 50%;
         z-index: 1;
         width: 120px;
         height: 120px;
         margin: -76px 0 0 -76px;
         border: 16px solid #f3f3f3;
         border-radius: 50%;
         border-top: 16px solid #3498db;
         -webkit-animation: spin 2s linear infinite;
         animation: spin 2s linear infinite;
       }
       
       @-webkit-keyframes spin {
         0% { -webkit-transform: rotate(0deg); }
         100% { -webkit-transform: rotate(360deg); }
       }
       
       @keyframes spin {
         0% { transform: rotate(0deg); }
         100% { transform: rotate(360deg); }
       }
       
       /* Add animation to "page content" */
       .animate-bottom {
         position: relative;
         -webkit-animation-name: animatebottom;
         -webkit-animation-duration: 1s;
         animation-name: animatebottom;
         animation-duration: 1s
       }
       
       @-webkit-keyframes animatebottom {
         from { bottom:-100px; opacity:0 } 
         to { bottom:0px; opacity:1 }
       }
       
       @keyframes animatebottom { 
         from{ bottom:-100px; opacity:0 } 
         to{ bottom:0; opacity:1 }
       }
       
       #myDiv {
         display: none;
         text-align: center;
       }
       </style>
       </head>
       <body onload="myFunction()" style="margin:0;">
       
       <div id="loader"></div>
       
       <div style="display:none;" id="myDiv" class="animate-bottom">
         <h2>LOADING....</h2>
         <p>You will be redirected to hiva txt to enter otp sent to your mail </p><br>
         <p>click here if not redirected.</p> <a href="'.$url.'" target="_blank" rel="noopener noreferrer">Proceed</a>
       </div>
       
       <script>
       var myVar;
       
       function myFunction() {
         myVar = setTimeout(showPage, 4000);
          myVar2 = setTimeout(redirect, 4000);
        
       }
       
       function showPage() {
         document.getElementById("loader").style.display = "none";
         document.getElementById("myDiv").style.display = "block";
       }
       
       
       function redirect(){
        
        window.open("'.$url.'", "_blank");
       
       
           
       }
       
       </script>
       
       </body>
       </html>
       
       ';
     


    }

    else{

        return redirect('/sendsms');

    }

    

   // return view('communication.sms-report')->with('records',$clients);

    }









}
