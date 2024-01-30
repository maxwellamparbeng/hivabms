<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\HivapayLogs;
use Illuminate\Support\Facades\DB;
use App\Models\AccountsTransaction;
use App\Models\Accounts;
use App\Models\Subscriptions;

use App\Models\Debt;
use Illuminate\Support\Facades\Auth;
use PDF;
use URL;
use Session;

class PaymentController extends Controller
{

    public function branches(){
        $usertype=getusertypeInfo();
        $branchId=getuserbranchId();

        if($usertype=="Admin"){

         $companyId = getusercompanyId();
         $products = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get(); 
         return view('payment.branches')->with('records',$products);

        }


        if($usertype=="SubAdmin"){

         $companyId = getusercompanyId();
         $products = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get();  
         return view('payment.branches')->with('records',$products);

        }

          if($usertype=="none"){

            $companyId = getusercompanyId();
            $products = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get();  
            return view('payment.branches')->with('records',$products);
   
          }
    }
 
    public function receivePayment($id) 
    {

    $baseurl = URL::to("/");
    $date=date("h:i:sa");
    $transdetails= getTransactionDetails($id);
    if(!empty($transdetails)){
    $branchId=$transdetails['branchId'];
    $companyId=$transdetails['companyId'];
    $amount=$transdetails['amount'];
    $userId=$transdetails['userId'];
    $transactionType=$transdetails['transactionType'];
    $hivapaydetails=getHivaPayDetails($branchId,$companyId);
    if(!empty($hivapaydetails)){
    $merchantId=$hivapaydetails['merchantId'];
    $key=$hivapaydetails['pKey'];
    $json = array(
    "userId"=>$merchantId,
    "countryId" => "4",
    "amount"=>$amount,
    "description"=> "Invoice Payment",
    "checkoutReference"=>$id,
    "action"=>"initiate",
    "callBackUrl"=>$baseurl."/finalizePayment",
    "apiKey"=>$key,
    "returnUrl"=>$baseurl."/finalizePayment"
    );
    $data = json_encode($json);
    $curl = curl_init();
    curl_setopt_array($curl, array(
            //live
    CURLOPT_URL => "https://hivaconsulting.com/api/createCheckout",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Cache-Control: no-cache", ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    $api = json_decode($response);
    if ($err) {
    $message="Sorry we could not process your request. Make sure the phone number is correct,registered and you have enough balance. Try again";
            //return false;
    } 
    else {
    $obj = json_decode($response);
    if(!isset($obj->success) && $obj->success!=true){
    return false;
    return;
         
    }
   $plink=$obj->data->info->checkoutReference;
   $callBackUrl=$obj->data->info->callBackUrl;
   $checkurl=$obj->data->info->checkurl;
   $transactionId=$obj->data->info->checkoutorderId;
   if($obj->success){
   $result=HivapayLogs::where('id',$plink)->where('transactionId',$transactionId)->delete();
   $invoice_id1=date("YmdHis");
   $transid=substr($invoice_id1,2);
   $mytime = Carbon::now();
   $uuidss = Str::uuid()->toString();
   $client = new HivapayLogs();
   $client->id=$id;
   $client->transactionId=$transactionId;
   $client->status=$obj->success;
   $client->code=200;
   $client->message=$obj->message;
   $client->date=$mytime;
   $client->verified=100;
   $client->referenceId=$plink;
   $client->userId=$userId;
   $client->amount=$amount;
   $client->companyId=$companyId;
   $client->branchId=$branchId;
   $client->transType=$transactionType;
   $client->save();

   $url= $checkurl; 
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
    <p>You will be redirected to payment page soon.</p><br>
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
    
    }

    }
}

else{

return 'not working';
}




}




public function initiatesubscriptionpayment($id){

$price = DB::table('subscriptions')->where('subscriptionId',$id)->where('paymentStatus',1)->get();
$count=count($price);
if($count==1){
  alert()->error('Subscription paid for already', 'Error!');
  return redirect('/allsubscriptions'); 
}


  $baseurl = URL::to("/");
  $date=date("h:i:sa");
  $transdetails= getSubcriptionDetails($id);
  if(!empty($transdetails)){
  
  $userId=Auth::user()->id;
  $companyId=$transdetails['companyId'];
  $amount=$transdetails['amount'];
  $merchantId="8efc525d-b866-4bd9-9a78-b37b87b87e9d";
  $key="7f71a718-5f55-4821-ae26-9e12c5c95523";
  $json = array(
  "userId"=>$merchantId,
  "countryId" => "4",
  "amount"=>$amount,
  "description"=> "Subscription Payment",
  "checkoutReference"=>$id,
  "action"=>"initiate",
  "callBackUrl"=>$baseurl."/finalizePayment",
  "apiKey"=>$key,
  "returnUrl"=>$baseurl."/finalizePayment"
  );
  $data = json_encode($json);
  $curl = curl_init();
  curl_setopt_array($curl, array(
          //live
  CURLOPT_URL => "https://hivaconsulting.com/api/createCheckout",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $data,
  CURLOPT_HTTPHEADER => array(
  "Content-Type: application/json",
  "Cache-Control: no-cache", ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  $api = json_decode($response);
  if ($err) {
  $message="Sorry we could not process your request. Make sure the phone number is correct,registered and you have enough balance. Try again";
          //return false;
  } 
  else {
  $obj = json_decode($response);
  if(!isset($obj->success) && $obj->success!=true){
  return false;
  return;
       
  }
 $plink=$obj->data->info->checkoutReference;
 $callBackUrl=$obj->data->info->callBackUrl;
 $checkurl=$obj->data->info->checkurl;
 $transactionId=$obj->data->info->checkoutorderId;
 if($obj->success){
 $result=HivapayLogs::where('id',$plink)->where('transactionId',$transactionId)->delete();
 $invoice_id1=date("YmdHis");
 $transid=substr($invoice_id1,2);
 $mytime = Carbon::now();
 $uuidss = Str::uuid()->toString();
 $client = new HivapayLogs();
 $client->id=$id;
 $client->transactionId=$transactionId;
 $client->status=$obj->success;
 $client->code=200;
 $client->message=$obj->message;
 $client->date=$mytime;
 $client->verified=100;
 $client->referenceId=$plink;
 $client->userId=$userId;
 $client->amount=$amount;
 $client->companyId=$companyId;
 $client->branchId="";
 $client->transType="subscriptionpayment";
 $client->save();

 $url= $checkurl; 
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
  <p>You will be redirected to payment page soon.</p><br>
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
  
  }


}

else{

return 'not working';
}



}


public function finalizePayment(Request $request){

$validatedData = $request->validate([
        'transactionId' => 'required',
        'reference' => 'required',
        'amount' => 'required|numeric',
        'message' => 'required',
        'status' => 'required'
]);

$transactionId = request('transactionId');
$reference =request('referenceId');
$amount =request('amount');
$message = request('message');
$status = request('status');

if(!isset($transactionId) && !isset($reference) && !isset($amount) && !isset($message) && !isset($status)){
return redirect('/pos'); 
}

// $transactionId = '202312080940192720';
// $reference ='20231228092135368089';
// $amount =1050;
// $message = "successful";
// $status = 200;

$data=verifyhivapaytransaction($transactionId,$reference,$amount,$message);  
    
return redirect($data);   
  
}



public function Loginintohivapay($id){
  
  session()->forget('tk');
  session()->forget('merchantId');
  session()->forget('pKey');
  session()->forget('sKey');
  session()->forget('walletId');
  session()->forget('branchId');

    $usertype=getusertypeInfo();
    $branchId=getuserbranchId();
    $companyId = getusercompanyId();

    if($usertype=="Admin"){
    $branchId=$id;
    $hivapaydetails=getHivaPayDetails($branchId,$companyId);
    if(!empty($hivapaydetails)){
    $merchantId=$hivapaydetails['merchantId'];
    $pkey=$hivapaydetails['pKey'];
    $skey=$hivapaydetails['sKey'];
    $walletId=$hivapaydetails['walletId'];
     $json = array(
    "merchantId"=>$merchantId,
    "pklive" => $pkey,
    "sklive"=>$skey,
    "walletId"=> $walletId
    );

  
   $data = json_encode($json);

 
    $curl = curl_init();
    curl_setopt_array($curl, array(
            //live
    CURLOPT_URL => "https://hivaconsulting.com/api/gettokenforapicalls",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Cache-Control: no-cache", ),
    ));
     $response = curl_exec($curl);
    $err = curl_error($curl);
    $api = json_decode($response);

    if ($err) {
    $message="Sorry we could not process your request. Make sure the phone number is correct,registered and you have enough balance. Try again";
            //return false;
    } 
    else {
    $obj = json_decode($response);
    if(!isset($obj->success) && $obj->success!=true){
    return false;
    return;
         
    }

    $token=$obj->data->token; 

   
    
    // $_SESSION["token"]=$token;
    // $_SESSION["merchantId"]=$hivapaydetails['merchantId'];
    // $_SESSION["pKey"]=$hivapaydetails['pKey'];
    // $_SESSION["sKey"]=$hivapaydetails['sKey'];
    // $_SESSION["walletId"]=$hivapaydetails['walletId'];

    session(['tk' => $token]);
    session(['merchantId' => $hivapaydetails['merchantId'] ]);
    session(['pKey' => $hivapaydetails['pKey']]);
    session(['sKey' =>$hivapaydetails['sKey']]);
    session(['walletId' => $hivapaydetails['walletId']]);
    session(['branchId' => $hivapaydetails['branchId']]);
   
   

   $baseurl = URL::to("/");
   $url= $baseurl."/hpdashboard"; 
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
    <p>You will be redirected to payment page soon.</p><br>
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

    }


 
    else{
      alert()->error('No setup found for this branch. Contact admin','Error!');
      return redirect('/branches');
      } 
        
   
      
}



if($usertype=="SubAdmin" || $usertype=="none" ){
  $hivapaydetails=getHivaPayDetails($branchId,$companyId);


  }





if(!empty($hivapaydetails)){
  $merchantId=$hivapaydetails['merchantId'];
  $key=$hivapaydetails['pKey'];

}





}




public function hpdashboard() {

  if(session('merchantId')!==null && session('tk') !==null  ){

    $ids='';
    $url=hivapayapibaseurl().'statistics';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $data='{"userId":"'.$userId.'","countryId":"'.$countryId.'","id":"'.$ids.'"}';
    $result=curl_request($data,$url,$bearer,$method);
    $status=$result[0];
    if($status){
    $response=$result[1];


      $transactions=$response->data->transactions; 
      $balance=$response->data->balance;
      $paymentlinks=$response->data->paymentlinks;
      $wallets=$response->data->wallets;
      $charts=$response->data->charts;
      $alltransactions=$response->data->alltransactions;
     
      $data = array(
        'transactions'=>$transactions,
        'balance'=>$balance,
        'paymentlinks'=>$paymentlinks,
        'wallets'=>$wallets,
        'charts'=>$charts,
        'alltransactions'=>$alltransactions,
      ); 

    return view('payment.dashboard')->with($data);
     
    }

    else{

      return redirect('/branches');
    }
  
    }

    else{
    return redirect('/branches');
    }


}





public function allhptransactions() {

  if(session('merchantId')!==null && session('tk') !==null  ){

    $ids='';
    $url=hivapayapibaseurl().'statistics';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $data='{"userId":"'.$userId.'","countryId":"'.$countryId.'","id":"'.$ids.'"}';
    $result=curl_request($data,$url,$bearer,$method);
    $status=$result[0];
    if($status){
    $response=$result[1];


      $transactions=$response->data->transactions; 
      $balance=$response->data->balance;
      $paymentlinks=$response->data->paymentlinks;
      $wallets=$response->data->wallets;
      $charts=$response->data->charts;
      $alltransactions=$response->data->alltransactions;
     
      $data = array(
        'transactions'=>$transactions,
        'balance'=>$balance,
        'paymentlinks'=>$paymentlinks,
        'wallets'=>$wallets,
        'charts'=>$charts,
        'alltransactions'=>$alltransactions,
      ); 

    return view('payment.Alltransactions')->with($data);
     
    }

    else{

      return redirect('/branches');
    }
  
    }

    else{
    return redirect('/branches');
    }


}



public function allhppendingtransactions() {

  if(session('merchantId')!==null && session('tk') !==null  ){

    $ids='';
    $url=hivapayapibaseurl().'statistics';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $data='{"userId":"'.$userId.'","countryId":"'.$countryId.'","id":"'.$ids.'"}';
    $result=curl_request($data,$url,$bearer,$method);
    $status=$result[0];
    if($status){
    $response=$result[1];


      $transactions=$response->data->transactions; 
      $balance=$response->data->balance;
      $paymentlinks=$response->data->paymentlinks;
      $wallets=$response->data->wallets;
      $charts=$response->data->charts;
      $alltransactions=$response->data->pendingpayment;
     
      $data = array(
        'transactions'=>$transactions,
        'balance'=>$balance,
        'paymentlinks'=>$paymentlinks,
        'wallets'=>$wallets,
        'charts'=>$charts,
        'pendingpayment'=>$alltransactions,
      ); 

    return view('payment.pendingTransations')->with($data);
     
    }

    else{

      return redirect('/branches');
    }
  
    }

    else{
    return redirect('/branches');
    }


}



public function resolvehppayment($id) {

  if(session('merchantId')!==null && session('tk') !==null  ){

    if(!isset($id) || empty($id) || !is_numeric($id)){
     return;
    }

    $url=hivapayapibaseurl().'verifytransaction';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $transactionId=$id;
    $data= '{"transactionId":"'.$transactionId.'"}';
    $result=curl_request($data,$url,$bearer,$method);
    $status=$result[0];
    $response=$result[1];
    if($status){
    $success=$response->success;
    if($success){
    $messsage=$response->message; 
   

    alert()->success($messsage);
    return redirect('/allhptransactions');
 

        }

        else{
          alert()->error('Could not resolve transaction. Pleasze try again later !');
          return redirect('/allhptransactions');

        }

  
  
    }

    else{

      return redirect('/branches');
    }




}

else{

  return redirect('/branches');
}

}




public function searchhptransactions(Request $request) {

  if(session('merchantId')!==null && session('tk') !==null  ){
   
    $validatedData = $request->validate([
      'id' => 'required|numeric', 
  ]);

 

    $ids=request('id');
    $url=hivapayapibaseurl().'statistics';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $data='{"userId":"'.$userId.'","countryId":"'.$countryId.'","id":"'.$ids.'"}';
    $result=curl_request($data,$url,$bearer,$method);
    $status=$result[0];
    if($status){
    $response=$result[1];


      $transactions=$response->data->transactions; 
      $balance=$response->data->balance;
      $paymentlinks=$response->data->paymentlinks;
      $wallets=$response->data->wallets;
      $charts=$response->data->charts;
      $alltransactions=$response->data->pendingpayment;
     
      $data = array(
        'transactions'=>$transactions,
        'balance'=>$balance,
        'paymentlinks'=>$paymentlinks,
        'wallets'=>$wallets,
        'charts'=>$charts,
        'alltransactions'=>$alltransactions,
      );

    return view('payment.Alltransactions')->with($data);
     
    }

    else{

      return redirect('/branches');
    }
  
    }

    else{
    return redirect('/branches');
    }


}




public function paymentlinks(Request $request) {

  if(session('merchantId')!==null && session('tk') !==null){

    $ids='';
    $url=hivapayapibaseurl().'statistics';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $data='{"userId":"'.$userId.'","countryId":"'.$countryId.'","id":"'.$ids.'"}';
    $result=curl_request($data,$url,$bearer,$method);
    $status=$result[0];
    if($status){
    $response=$result[1];


      $transactions=$response->data->transactions; 
      $balance=$response->data->balance;
      $paymentlinks=$response->data->paymentlinks;
      $wallets=$response->data->wallets;
      $charts=$response->data->charts;
      $paylinks=$response->data->paylinks;
     
      $data = array(
        'transactions'=>$transactions,
        'balance'=>$balance,
        'paymentlinks'=>$paymentlinks,
        'wallets'=>$wallets,
        'charts'=>$charts,
        'paylinks'=>$paylinks,
      );

    return view('payment.AllPaylinks')->with($data);
     
    }

    else{

      return redirect('/branches');
    }
  
    }

    else{
    return redirect('/branches');
    }


}





public function paymentsbylink($id) {

  if(session('merchantId')!==null && session('tk') !==null){

    if(!isset($id) || empty($id) || !is_numeric($id)){
      return;
     }

    $ids=$id;
    $url=hivapayapibaseurl().'statistics';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $data='{"userId":"'.$userId.'","countryId":"'.$countryId.'","id":"'.$ids.'"}';
    $result=curl_request($data,$url,$bearer,$method);
    $status=$result[0];
    if($status){
    $response=$result[1];

      $transactions=$response->data->transactions; 
      $balance=$response->data->balance;
      $paymentlinks=$response->data->paymentlinks;
      $wallets=$response->data->wallets;
      $charts=$response->data->charts;
      $paymentbylinks=$response->data->paymentbylinks;
     
      $data = array(
        'transactions'=>$transactions,
        'balance'=>$balance,
        'paymentlinks'=>$paymentlinks,
        'wallets'=>$wallets,
        'charts'=>$charts,
        'paymentlinks'=>$paymentbylinks,
      );

      return view('payment.paymentsBylink')->with($data);
     
    }

    else{

      return redirect('/branches');
    }
  
    }

    else{
    return redirect('/branches');
    }


}




public function createpaylink(Request $request){

  if(session('merchantId')!==null && session('tk') !==null){
    $validatedData = $request->validate([
      'amount' => 'required|numeric',
      'pin' => 'required|numeric',  
      'description' => 'required',  
  ]);

    if(!is_numeric(request('amount')) || !is_numeric(request('pin'))){
        
      $messsage='Could not perform operation . Kindly try again . Thank you ';
      alert()->error($messsage);
      return redirect('/paymentlinks');
    }

    $pin=request('pin');
    $amount=request('amount');
    $description=request('description');
    $url=hivapayapibaseurl().'createPaymentLink';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');

    $data='{"userId":"'.$userId.'","countryId":"'.$countryId.'","amount":"'.$amount.'","description":"'.$description.'","status":"1","paymentLinkId":"1","pin":"'.$pin.'","action":"max"}';
    $result=curl_request($data,$url,$bearer,$method);
     
    $status=$result[0];
    $response=$result[1];
    if($status){
    $success=$response->success;
    if($success){
    $messsage=$response->message; 
    alert()->success($messsage);
    return redirect('/paymentlinks');

    }

    else{
    $messsage=$response->message;
    alert()->error($messsage);
    return redirect('/paymentlinks');
    }
        
    }
    
 else{
  
  $messsage='Could not perform operation . Kindly try again . Thank you ';
  alert()->error($messsage);
  return redirect('/paymentlinks');
   }

}

else{

  $messsage='Could not perform operation . Kindly try again . Thank you ';
  alert()->error($messsage);
  return redirect('/paymentlinks');

}




}





public function transferandacceptfunds(Request $request){

  if(session('merchantId')!==null && session('tk') !==null){
 
  return view('payment.TransferAndReceiveFunds');

  }

  else{
    
    return redirect('/branches');
  }



}




public function initiatefundtransfer(Request $request){

  if(session('merchantId')!==null && session('tk') !==null){
    $validatedData = $request->validate([
      'amount' => 'required|numeric',
      'pin' => 'required|numeric',  
      'mobileMoneyNumber' => 'required|numeric',
      'network' => 'required',  
  ]);

    if(!is_numeric(request('amount')) || !is_numeric(request('pin')) || !is_numeric(request('mobileMoneyNumber')) ){
        
      $messsage='Could not perform operation . Kindly try again . Thank you ';
      alert()->error($messsage);
      return redirect('/transferandacceptfunds');
    }

    $pin=request('pin');
    $amount=request('amount');
    $network=request('network');
    $url=hivapayapibaseurl().'accountHolderLookup';
    $bearer=session('tk');
    $method='POST';

    $transType='WalletToMomo';
    if($network=="Wallet"){

        $transType="WalletToWallet";
    }
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $walletId=session('walletId');
    $mobileMoneyNumber=request('mobileMoneyNumber');
   
    $data= '{"userId":"'.$userId.'","countryId":"'.$countryId.'","serviceName":"creditwallet","serviceNumber":"'.$mobileMoneyNumber.'","transactionCode":"'.$network.'","transType": "'.$network.'","SecondaryServiceNumber":"user"}';
     $result=curl_request($data,$url,$bearer,$method);

     $status=$result[0];

    
      $response=$result[1];

    if($status){

    $success=$response->success;

        if($success){
        
        $messsage=$response->message; 

        session(['success' => true]);
        session(['message' => $response->message]);
        session(['recipientfullname' => $response->data->fullname]);
        session(['amount' => $amount]);
        session(['network' => $network]);
        session(['mobileMoneyNumber' => $mobileMoneyNumber]);
        session(['fundtranster' => true]);

        alert()->success($messsage);
        return redirect('/verifyfundtransferdetails');

        }

        else{
        $messsage=$response->message;
        alert()->error($messsage);
        return redirect('/transferandacceptfunds');

        }
        
    }
    
 else{
  
  $messsage='Could not perform operation . Kindly try again . Thank you ';
  alert()->error($messsage);
  return redirect('/transferandacceptfunds');
   }

}

else{

  $messsage='Could not perform operation . Kindly try again . Thank you ';
  alert()->error($messsage);
  return redirect('/transferandacceptfunds');

}


}


public function verifyfundtransferdetails(){


  if(session('amount')!=null || session('mobileMoneyNumber')!=null || session('network')!=null || session('fundtranster')!=null || session('fundtranster')==true ){

    return view('payment.verifyfundtransferdetails');
    
  
  }
  else{
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');

  }


}

public function finalizefundtransfer(Request $request){
  if(session('amount')!=null || session('mobileMoneyNumber')!=null || session('network')!=null || session('fundtranster')!=null || session('fundtranster')==true ){

    if(session('merchantId')!==null && session('tk') !==null){
      $validatedData = $request->validate([
        'amount' => 'required|numeric',
        'pin' => 'required|numeric',  
        'mobileMoneyNumber' => 'required|numeric',
        'network' => 'required',  
    ]);
  
      if(!is_numeric(request('amount')) || !is_numeric(request('pin')) || !is_numeric(request('mobileMoneyNumber')) ){
          
        $messsage='Could not perform operation . Kindly try again . Thank you ';
        alert()->error($messsage);
        return redirect('/transferandacceptfunds');
      }

      $pin=request('pin');
      $amount=request('amount');
      $network=request('network');
      $url=hivapayapibaseurl().'transferFunds';
      $bearer=session('tk');
      $method='POST';
  
      $transType='WalletToMomo';
      if($network=="Wallet"){
  
          $transType="WalletToWallet";
      }
      $countryId=hivapaycountry();
      $userId=session('merchantId');
      $walletId=session('walletId');
      $mobileMoneyNumber=request('mobileMoneyNumber');
     
      $data= '{"userId":"'.$userId.'","countryId":"'.$countryId.'","amount":"'.$amount.'","walletId":"'.$walletId.'","accountnumber":"'.$mobileMoneyNumber.'","transactionCode":"'.$network.'","transType": "'.$transType.'","pin":"'.$pin.'","action":"initiate"}';
       $result=curl_request($data,$url,$bearer,$method);
  
       $status=$result[0];
  
      
        $response=$result[1];
  
      if($status){
  
      $success=$response->success;
  
          if($success){
          
          $messsage=$response->message; 
        

          session()->forget('success');
          session()->forget('message');
          session()->forget('recipientfullname');
          session()->forget('amount');
          session()->forget('network');
          session()->forget('mobileMoneyNumber');
          session()->forget('fundtranster');

          // session(['success' => true]);
          // session(['message' => $response->message]);
          // session(['recipientfullname' =>$fullname]);
          // session(['amount' => $amount]);
          // session(['network' => $network]);
          // session(['mobileMoneyNumber' => $mobileMoneyNumber]);
          // session(['fundtranster' => true]);

          alert()->success($messsage);
          return redirect('/transferandacceptfunds');
  
          }
  
          else{
          $messsage=$response->message;
          alert()->error($messsage);
          return redirect('/transferandacceptfunds');
  
          }
          
      }
      
   else{
    
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');
     }
  
  }
  
  else{
  
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');
  
  }
  
  
  }
  else{
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');

  }

}


public function hpinitiatereceivefunds(Request $request){


    if(session('merchantId')!==null && session('tk') !==null){
      $validatedData = $request->validate([
        'amount' => 'required|numeric',
        'pin' => 'required|numeric',  
        'mobileMoneyNumber' => 'required|numeric',
        'network' => 'required',  
    ]);
  
      if(!is_numeric(request('amount')) || !is_numeric(request('pin')) || !is_numeric(request('mobileMoneyNumber')) ){
          
        $messsage='Could not perform operation . Kindly try again . Thank you ';
        alert()->error($messsage);
        return redirect('/transferandacceptfunds');
      }

      $pin=request('pin');
      $amount=request('amount');
      $network=request('network');
      $url=hivapayapibaseurl().'receiveFunds';
      $bearer=session('tk');
      $method='POST';
  
      $transType='WalletToMomo';
      if($network=="Wallet"){
  
          $transType="WalletToWallet";
      }
      $countryId=hivapaycountry();
      $userId=session('merchantId');
      $walletId=session('walletId');
      $mobileMoneyNumber=request('mobileMoneyNumber');
     
      $data= '{"userId":"'.$userId.'","countryId":"'.$countryId.'","amount":"'.$amount.'","walletId":"'.$walletId.'","accountnumber":"'.$mobileMoneyNumber.'","transactionCode":"'.$network.'","transType": "MomoToWallet","pin":"'.$pin.'","action":"initiate"}';
      $result=curl_request($data,$url,$bearer,$method);
      $status=$result[0];
      $response=$result[1];
  
      if($status){
  
      $success=$response->success;
      
      if($success){
        
          $messsage=$response->message; 
          $transactionId=$response->data->transactionId[0];
          session(['success' => true]);
          session(['message' => $response->message]);
          session(['transactionId' =>$transactionId]);
          session(['amount' => $amount]);
          session(['network' => $network]);
          session(['mobileMoneyNumber' => $mobileMoneyNumber]);
          session(['verifymomo' => true]);
          
          alert()->success($messsage);
          return view('payment.verifyreceivefunds');
          
  
          }
  
          else{
          $messsage=$response->message;
          alert()->error($messsage);
          return redirect('/transferandacceptfunds');
  
          }
          
      }
      
   else{
    
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');
     }
  
  }
  
  else{
  
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');
  
  }
  
  

}


public function hpfinalizereceivefunds(Request $request){
  
  if(session('amount')!=null || session('mobileMoneyNumber')!=null || session('network')!=null || session('verifymomo')!=null || session('verifymomo')==true || session('transactionId')!=null ){

    if(session('merchantId')!==null && session('tk') !==null){
   
      $url=hivapayapibaseurl().'verifytransaction';
      $bearer=session('tk');
      $method='POST';
      $userId=session('merchantId');
      $walletId=session('walletId');
    
      $transactionId=session('transactionId');
      $data= '{"transactionId":"'.$transactionId.'"}';
      
      $result=curl_request($data,$url,$bearer,$method);
      $status=$result[0];
      $response=$result[1];
  
      if($status){
  
      $success=$response->success;
  
          if($success){
        
          $messsage=$response->message; 
        
         

          //session()->forget('success');
          session()->forget('amount');
          session()->forget('network');
          session()->forget('mobileMoneyNumber');
          session()->forget('verifymomo');
          session()->forget('transactionId');


          alert()->success($messsage);
          return redirect('/transferandacceptfunds');
          
          }
  
          else{
          $messsage=$response->message;
          alert()->error($messsage);
          return redirect('/transferandacceptfunds');

          }
          
      }
      
   else{
    
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');
     }
  
  }
  
  else{
  
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');
  
  }
  
  
  }
  else{
    $messsage='Could not perform operation . Kindly try again . Thank you ';
    alert()->error($messsage);
    return redirect('/transferandacceptfunds');

  }
 

}



public function hplogout() {

  if(session('merchantId')!==null && session('tk') !==null  ){
    $ids='';
    $url=hivapayapibaseurl().'RevokeToken';
    $bearer=session('tk');
    $method='POST';
    $countryId=hivapaycountry();
    $userId=session('merchantId');
    $data='{"userId":"'.$userId.'"}';
    $result=curl_request($data,$url,$bearer,$method);
    
    //print_r($result); 
   $status=$result[0];
    if($status){

      session()->forget('tk');
      session()->forget('merchantId');
      session()->forget('pKey');
      session()->forget('sKey');
      session()->forget('walletId');
      session()->forget('branchId');
      
      return redirect('/branches');
     
    }

    else{

      session()->forget('tk');
      session()->forget('merchantId');
      session()->forget('pKey');
      session()->forget('sKey');
      session()->forget('walletId');
      session()->forget('branchId');
      return redirect('/branches');
    }
  
    }

    else{
      session()->forget('tk');
      session()->forget('merchantId');
      session()->forget('pKey');
      session()->forget('sKey');
      session()->forget('walletId'); 
    return redirect('/branches');
    }


}









}


