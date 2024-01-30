<?php
use App\Models\Job;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Transaction;
use \Carbon\Carbon;
use App\Models\PayrollDetails;
use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\InventoryTransferLog;
use App\Models\WarehouseInventory;
use App\Models\Product;
use App\Models\User;
use App\Models\Subscriptions;
use App\Models\ContactGroup;
use App\Mail\SendMail;

function allsalary() {
$userInfo = getusercompanyId();
$userdetails = DB::table('salary')->where('companyId', $userInfo)->get();  
return $userdetails;

}


function alldept() {
  
  $userInfo = getusercompanyId();
  $userdetails = DB::table('department')->where('companyId', $userInfo)->get();  
  return $userdetails;

}


function allpositions() {
  
  $userInfo = getusercompanyId();
  $userdetails = DB::table('job')->where('companyId', $userInfo)->get();  
  return $userdetails;

}




function alledu() {
  
  $userInfo = getusercompanyId();
  $userdetails = DB::table('education')->get();  
  return $userdetails;

}




function getusercompanyId(){ 
$userInfo = Auth::user()->id;
$userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
$comapanyId=$userdetails->companyId;
return $comapanyId;
}


function getcompanyhivapaystatus(){ 
  $userInfo = Auth::user()->id;
  $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
  $hivapay=$userdetails->hivapay;
  return $hivapay;
}


function getusertypeInfo(){ 
  $userInfo = Auth::user()->id;
  $userdetails = DB::table('users')->where('users.id', $userInfo)->first();  
  $comapanyId=$userdetails->userType;
  return $comapanyId;
  }


  function getuserbranchId(){ 
    $userInfo = Auth::user()->id;
    $userdetails = DB::table('users')->where('users.id', $userInfo)->first();  
    $comapanyId=$userdetails->branchId;
    return $comapanyId;
    }


function getusercompanystockinfo(){ 
    $userInfo = Auth::user()->id;
    $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
    $comapanyId=$userdetails->stockReduction;
    return $comapanyId;
}


function getusercompanyposbarcodescannerinfo(){ 
  $userInfo = Auth::user()->id;
  $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
  $comapanyId=$userdetails->posBarcodeScanner;
  return $comapanyId;
}




function getusercompanyproductpricinginfo(){ 
  $userInfo = Auth::user()->id;
  $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
  $comapanyId=$userdetails->ProductPricing;
  return $comapanyId;
}



function productquantity($proId){ 
    $userInfo = Auth::user()->id;
    $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
    $comapanyId=$userdetails->companyId;
    $products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->where('products.companyId',$comapanyId)->where('products.productId', '=',$proId)->first(); 
    $quantity=$products->quantity;

    return $quantity;
}


function getbarcodeId($barcodeid){
$products = DB::table('products')->where('products.barcode', '=',$barcodeid)->get(); 
 $count=count($products);

  if($count>0){

    foreach ($products as $product) {

      $proId= $product->productId;
   

     }


 
   return  $proId;
  }
  else{
   $nodata='no data';
    return $nodata;
  }

}



function updateOrderamount($id){ 

  $total_price = 0;
  $userInfo = Auth::user()->id;
  $cartdata =DB::table('transaction_details')->join('products','products.productId', '=', 'transaction_details.productId')->where('transaction_details.userId',$userInfo)->get();
         
  $count=count($cartdata);
  
    if($count>0){
        foreach ($cartdata as $carts) {
      $total_price += $carts->detailsQuantity*$carts->price;
  
        }
  
      }

      //update transaction amount
     $cart = Transaction::find($id);
     $cart->transactionId = $uuid;
     $cart->totalAmount = $total_price;
     $cart->tendered = $total_price;
     $cart->save();


}


function getCarttotal(){ 

  $total_price = 0;
  $userInfo = Auth::user()->id;
  //$cartdata =DB::table('cart')->join('products','products.productId', '=', 'cart.productId')->where('cart.userId',$userInfo)->get();     
  
  $cartdata=DB::table('cart')->where('cart.userId',$userInfo)->get();
  
  $count=count($cartdata);
  
    if($count>0){
        foreach ($cartdata as $carts) {
      $total_price += $carts->cartQuantity*$carts->price;
  
        }
  
      }

      return $total_price;
}


function getinvoiceCarttotal(){ 

  $total_price = 0;
  $userInfo = Auth::user()->id;
  //$cartdata =DB::table('invoicecart')->join('products','products.productId', '=', 'invoicecart.productId')->where('invoicecart.userId',$userInfo)->get();     
  
  $cartdata=DB::table('invoicecart')->where('invoicecart.userId',$userInfo)->get();   
  
  $count=count($cartdata);
  
    if($count>0){
        foreach ($cartdata as $carts) {
      $total_price += $carts->cartQuantity*$carts->price;
  
        }
  
      }

      return $total_price;
}







function viewposinvoicedetails($id){


  $mytime = Carbon::now();

  $demo_string = preg_replace("/[^a-zA-Z,\"{}:]/", "",$mytime);;
 //echo $demo_string = str_replace(' ', '','',$mytime);
  $companyId = getusercompanyId();    
  $userInfo = Auth::user()->id;

  $company = DB::table('company')->where('companyId',$companyId)->first();
  $details =DB::table('transactions')->where('transactionId',$id)->first();

  $data = array(
    'subtotal'=>$details->tendered,
    'invoiceId'=>$id,
    'customer'=>$details->customer,
    'address'=>$details->address,
    'phone'=>$details->phone,
    'email'=>$details->email,
    'total'=>$details->totalAmount,
    'paymentStatus'=>$details->paymentMethod,
    'created_at'=>$details->created_at,
    'status'=>'1', //$details->status,
    'total'=>$details->totalAmount+$details->discount-$details->vat,
    'paymentType'=>$details->paymentMethod,
    'discount'=>$details->discount,
    'vat'=>$details->vat,
    'note'=>$details->note,
    'vatDetails'=>$details->vatDetails,
    'vatPercentage'=>$details->vatPercentage,
     );
     return $data;


    }

  

function viewinvoicedetails($id){


  $mytime = Carbon::now();

  $demo_string = preg_replace("/[^a-zA-Z,\"{}:]/", "",$mytime);;
 //echo $demo_string = str_replace(' ', '','',$mytime);
  $companyId = getusercompanyId();    
  $userInfo = Auth::user()->id;

  $company = DB::table('company')->where('companyId',$companyId)->first();
  $details =DB::table('invoice')->where('invoiceId',$id)->first();

  $data = array(
    'subtotal'=>$details->tendered,
    'invoiceId'=>$id,
    'customer'=>$details->customerName,
    'address'=>$details->address,
    'phone'=>$details->phoneNumber,
    'email'=>$details->email,
    'total'=>$details->amount+$details->discount-$details->vat,
    'paymentStatus'=>$details->	paymentStatus,
    'invoiceType'=>$details->invoiceType,
    'created_at'=>$details->created_at,
    'status'=>$details->status,
    'note'=>$details->note,
    'total'=>$details->amount+$details->discount-$details->vat,
    'paymentType'=>$details->paymentType,
    'discount'=>$details->discount,
    'vat'=>$details->vat,
    'vatDetails'=>$details->vatDetails,
    'vatPercentage'=>$details->vatPercentage,
     );
     return $data;

 
 }





 function getorderdetails($id){ 
 
  $companyId = getusercompanyId();    
  $userInfo = Auth::user()->id;
  $company = DB::table('company')->where('companyId',$companyId)->get();
  $cartdata =DB::table('transaction_details')->join('products','products.productId', '=', 'transaction_details.productId')->where('transaction_details.transactionId',$id)->get();
  $details=DB::table('transactions')->where('transactions.transactionId',$id)->first();

  $data = array(
    'customer'=>$details->customer,
    'address'=>$details->address,
    'phone'=>$details->phone,
    'email'=>$details->email,
    'total'=>$details->totalAmount,
     );
     return $data;

}










function displayImage($filename) {
$path = storage_public('images/' . $filename);
if (!File::exists($path)) {
abort(404);
}
$file = File::get($path);
$type = File::mimeType($path);
$response = Response::make($file, 200);
$response->header("Content-Type", $type);
return $response;
}



function checkIfuserIsLoggedIn(){
  
  
  if (!Auth::check()) {
    // The user is logged in...
    return redirect()->to('login');
  }


}


function companyinfo(){

  $userInfo = Auth::user()->id;
  $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
  $companyId=$userdetails->companyId;

  $data = array(
    'companyId'=>$companyId,
    'name'=>$userdetails->companyName,
    'phone'=>$userdetails->phoneNumber,
    'email'=>$userdetails->email,
     );
return $data;


}


function Idgenerator()
{

  $RAND1 = rand(1000,9999);
  $Date_            =  date("Y-m-d h:i:s");
  $Date1_           =  str_replace(" ","",$Date_);
  $Date2_           =  str_replace(":","",$Date1_);
  $Date3_           =  str_replace("-","",$Date2_);
  $Date4_           =  str_replace("/","",$Date3_);
  $TRANSACTION_ID1  =  $Date4_.$RAND1;   
  $ID1              = sha1($TRANSACTION_ID1);
  return $TRANSACTION_ID1;


}





function numberTowords($num)
{

$ones = array(
0 =>"ZERO",
1 => "ONE",
2 => "TWO",
3 => "THREE",
4 => "FOUR",
5 => "FIVE",
6 => "SIX",
7 => "SEVEN",
8 => "EIGHT",
9 => "NINE",
10 => "TEN",
11 => "ELEVEN",
12 => "TWELVE",
13 => "THIRTEEN",
14 => "FOURTEEN",
15 => "FIFTEEN",
16 => "SIXTEEN",
17 => "SEVENTEEN",
18 => "EIGHTEEN",
19 => "NINETEEN",
"014" => "FOURTEEN"
);
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY",
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND", 
"MILLION", 
"BILLION", 
"TRILLION", 
"QUARDRILLION" 
); /*limit t quadrillion */
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
	
while(substr($i,0,1)=="0")
		$i=substr($i,1,5);
if($i < 20){ 
/* echo "getting:".$i; */
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
}
} 
if($decnum > 0){
$rettxt .= " and ";
if($decnum < 20){
$rettxt .= $ones[$decnum];
}elseif($decnum < 100){
$rettxt .= $tens[substr($decnum,0,1)];
$rettxt .= " ".$ones[substr($decnum,1,1)];
}
}
return $rettxt;
}






function calculatepayroll($empId,$payrollId){
  
  $userInfo = Auth::user()->id;
  $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
  $comapanyId=$userdetails->companyId;
  
  $empdeduction = DB::table('employee_deductions')->join('deductions', 'deductions.deductionId', '=', 'employee_deductions.deductionId')->where('employeeId',$empId)->get();
  $totalDeduction=$empdeduction->sum('amount');
  
  $empallowance = DB::table('employee_allowances')->join('allowances', 'allowances.allowanceId', '=', 'employee_allowances.allowanceId')->where('employeeId',$empId)->get();
  $totalAllowance=$empallowance->sum('amount');

  $present=DB::table('employee')->join('employeeattendance','employeeattendance.employeeId', '=', 'employee.employeeId')->where('employeeattendance.payrollId',$payrollId)->where('employeeattendance.employeeId',$empId)->first()->noDays;
 
  $noDays= $present;

  $empSalary=DB::table('employee')->join('salary','salary.salaryId', '=', 'employee.salaryId')->where('employee.employeeId',$empId)->first()->salaryName;

  $salary=$empSalary;

  $basesalary= $salary/22;
  
  $numberofdaysalary = $basesalary*$noDays;

  $net=$numberofdaysalary+$totalAllowance-$totalDeduction;
  


  //caculation of ssnit

  $ssnit=$numberofdaysalary*0.055;


  $taxablePay=$numberofdaysalary-$ssnit+$totalAllowance;

 //1118.975

  //income tax calculation

  $first365percentage=0.00;
  $second110percentage=5.50;
  $third130percentage=13.00;
  $fourth3000percentage=17.5;
  $fifthpercentage=0.25;
  $sixpercent= 0.3;

  $first365Amount=365;
  $second110Amount=110;
  $third130Amount=130;
  $fourth3000Amount=3000;
  $fifthperAmount=16395;
  $sixAmount= 20000;

  $continue=true;


  
  $deduction20000percentagecal=0;
  $deduction16395percentagecal=0;
  $deduction130percentagecal=0;
  $deduction110percentagecal=0;
  $deduction3000percentagecal=0;


  $deduction365=0;
  $deduction110=0;
  $deduction130=0;
  $deduction3000=0;
  $deduction16395=0;
  $deduction20000=0;



  if($taxablePay<=364){

    $continue=false;

  }

  

  if($continue){
    
    
    if($taxablePay>=$first365Amount){

       $deduction365= $taxablePay-$first365Amount;
  
      
    }
  
  
  
    if($taxablePay<$first365Amount){
  
      $deduction365= $taxablePay-$first365Amount;
  
      $continue=false;
      
    }


  }

  //753.975



  if($continue){

    if($deduction365>=$second110Amount){



      $deduction110= $deduction365-$second110Amount;
  
      $deduction110percentagecal=5.50;
  
  
      // 635-110=525;
  
      // calculate the percentage on the 110 if the remaining amount is greater than 
  
      // 110.
  
  
      // 5.50
  
      // if its not more than 110 calcualte the percentage on the remaining amount 
  
      // calculation stops there .
  
      
    }
  
  
  
    if($deduction365<$second110Amount){
  

      $deduction110= $deduction365-$second110Amount;
   
      $deduction110percentagecal=5.50/100*$deduction110;

    
      $continue=false;
  
    }

  }


  //643.975
  


  if($continue){
    
    if($deduction110>=130){



      $deduction130= $deduction110-130;
  
      $deduction130percentagecal=13.00;

      
    }
  
  
  
    if($deduction110<130){
  
      $deduction130= $deduction110-130;
  
      $deduction130percentagecal=13.00/100*$deduction110;
  
  
      $continue=false;
  
    }

  }

//513.975
 


  if($continue){

    if($deduction130>=3000){

      $deduction3000= $deduction130-3000;
  
      $deduction3000percentagecal=17.5;
  
    }
  
  
    if($deduction130<3000){
  
      $deduction3000= $deduction130-3000;
  
      $deduction3000percentagecal=17.5/100*$deduction130;
      $continue=false;
  
    }

  }


 //-2486.025

  


  if($continue){

    if($deduction3000>=16395){

      $deduction16395= $deduction3000-16395;
  
      $deduction16395percentagecal=0.25;
  
  
  
  
    }
  
  
    if($deduction3000<16395){
  
      $deduction16395= $deduction3000-16395;
  
      $deduction16395percentagecal=0.25/100*$deduction3000;
  
  
      $continue=false;

    }
  





  }


 


  if($continue){
    if($deduction16395>=20000){

      $deduction20000= $deduction130-20000;
  
      $deduction20000percentagecal=0.3;
  
  
  
  
    }
  
  
    if($deduction16395<20000){
  
      $deduction20000= $deduction130-20000;
  
      $deduction20000percentagecal=0.3/100*$deduction16395;
  
  
    }

  }

 
$incometax = $deduction20000percentagecal+$deduction16395percentagecal+$deduction130percentagecal+$deduction110percentagecal+$deduction3000percentagecal;

  
  $data = array(
    'deductionAmount'=>$totalDeduction,
    'allowanceAmount'=>$totalAllowance,
    'net'=>$net,
    'salary'=>$numberofdaysalary,
    'present'=>$noDays,
    'allowance'=>$empallowance,
    'deduction'=>$empdeduction,
    'netSalary'=>$taxablePay-$incometax,
    'taxablePay'=>$taxablePay,
    'incomeTax'=>$incometax,
    'ssnit'=>$ssnit
     );

    

     $mytime = Carbon::now();
     $uuid = Str::uuid()->toString();
     $client = new PayrollDetails();
     $client->id =$uuid;
     $client->payroll_id = $payrollId;
     $client->employee_id = $empId ;
     $client->present=''  ;
     $client->absent=''  ;
     $client->late=''  ;
     $client->salary=$salary  ;
     $client->allowance_amount = $totalAllowance;
     $client->deduction_amount = $totalDeduction;
     $client->allowances = $empallowance;
     $client->deductions = $empdeduction;
     $client->net = $taxablePay-$incometax-$totalDeduction;
     $client->date_created = $mytime;
     $client->taxablePay = $taxablePay;
     $client->incomeTax = $incometax;
     $client->ssnit = $ssnit;
     $client->createdBy = $userInfo;
     $client->save();

  //return $data;




}







function displaypayrolldetails($empId,$payrollId){
  


   $payrolldetails = DB::table('payroll_items')->where('employee_id',$empId)->where('payroll_id',$payrollId)->first();  
  

  
    $incometax=$payrolldetails->incomeTax;
  
  $net=$payrolldetails->net;
  $taxablePay=$payrolldetails->taxablePay;
  $ssnit=$payrolldetails->ssnit;
  $salary=$payrolldetails->salary;
  $totalDeduction=$payrolldetails->deduction_amount;
  $totalAllowance=$payrolldetails->allowance_amount;
  $empallowance=$payrolldetails->allowances;
  $empdeduction=$payrolldetails->deductions;
  $noDays=$payrolldetails->present;

  $data = array(
    'deductionAmount'=>$totalDeduction,
    'allowanceAmount'=>$totalAllowance,
    'net'=>$net,
    'salary'=>$salary,
    'present'=>$noDays,
    'allowance'=>$empallowance,
    'deduction'=>$empdeduction,
    'netSalary'=>$net,
    'taxablePay'=>$taxablePay,
    'incomeTax'=>$incometax,
    'ssnit'=>$ssnit
     );


  return $data;




}














function getEmployeeDeductions($empId){
  
    $userInfo = Auth::user()->id;
    $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
    $comapanyId=$userdetails->companyId;
    $empdeduction = DB::table('employee_deductions')->join('deductions', 'deductions.deductionId', '=', 'employee_deductions.deductionId')->where('employeeId',$empId)->get();
    return $empdeduction;

}


function getEmployeeAllowance($empId){
  
    $userInfo = Auth::user()->id;
    $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
    $comapanyId=$userdetails->companyId;
    $empdeduction = DB::table('employee_allowances')->join('allowances', 'allowances.allowanceId', '=', 'employee_allowances.allowanceId')->where('employeeId',$empId)->get();
    return $empdeduction;

}



function getsmscredentials(){ 

$userInfo = Auth::user()->id;
$userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
$smsapiusername = $userdetails->smsApiusername;
$smsapikey = $userdetails->smsApikey;
return array($smsapiusername, $smsapikey);


}


  
function getsmsbalance($smsapiusername , $smsapikey){

    $url = 'https://hivatxt.com/sms/index.php/Api/checksmsbalance';
    $ch = curl_init($url);
    $data = array(
        'apikey' => $smsapikey,
        'username' => $smsapiusername
      );

    $payload = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $result2 = json_decode($result);
    curl_close($ch);
    $status=$result2->status;
    $balance=$result2->balance;
    return $balance;
  }
  
  


function sendsms ($phonenumber , $message , $smsapiusername , $smsapikey , $senderName){  

$List = implode(',', $phonenumber);

$url = 'https://hivatxt.com/sms/index.php/Api/sendsms';
$ch = curl_init($url);
$data = array(
  'apikey' => $smsapikey,
  'username' => $smsapiusername,
    'contacts'=>implode(',', $phonenumber),
    'sender'=>$senderName,
    'message'=>$message
);
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$result2 = json_decode($result);
curl_close($ch);

return $result2 ;


}



function email($message,$to,$subjects,$view){
$vw='emails.testMail';
$testMailData = [
  'title' => 'Test Email From AllPHPTricks.com',
  'body' => 'This is the body of test email.'
];
Mail::to($to)->send(new SendMail($subjects,$message,$vw,$testMailData));

}


function inventorylog($branchId,$product,$proQuantity,$total,$inventoryId,$companyId,$userInfo,$uuid){

  $uuid2=Str::uuid()->toString();
  $productdetails = new InventoryLog();
  $productdetails->branchId = $branchId;
  $productdetails->productId = $product;
  $productdetails->inventoryQuantityBefore =$total;
  $productdetails->inventoryQuantityAfter =$proQuantity;
  $productdetails->inventoryId = $inventoryId;
  $productdetails->inventorylogId =$uuid2;
  $productdetails->companyId =$companyId;
  $productdetails->dateCreated = date('Y-m-d');
  $productdetails->userId= $userInfo;  
  $productdetails->transactionId= $uuid; 
  $productdetails->save();

  }


  function stocktransferlog($frombranchId,$productId,$tobranchId,$userId,$quantity,$companyId,$transferType){

    $uuid=Str::uuid()->toString();
    $productdetails = new InventoryTransferLog();
    $productdetails->frombranchId = $frombranchId;
    $productdetails->tobranchId = $tobranchId;
    $productdetails->productId = $productId;
    $productdetails->companyId =$companyId;
    $productdetails->quantity =$quantity;
    $productdetails->dateCreated = date('Y-m-d');
    $productdetails->userId= $userId;  
    $productdetails->id= $uuid; 
    $productdetails->transferType=$transferType;
    $productdetails->save();
  
    }


function productadditiontostock() {  
$userInfo = Auth::user()->id;
$userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
$companyId=$userdetails->companyId;
$branchdata =DB::table('branches')->where('branches.companyId',$companyId)->get();
$count=count($branchdata);
if($count>0){
foreach ($branchdata as $branch) {
$branchId = $branch->branchId;
productaddition($branchId);
}
}
}



function getbranchfromTransaction($id){

  $sql="SELECT * FROM `transactions` where transactionId='$id' and  transactions.status='COMPLETED' LIMIT 1";
  $details =DB::select(DB::raw($sql));
  $count=count($details);
  if($count>0){
  foreach ($details as $branch) {
  $branchId = $branch->branchId;
  return $branchId;
  }

}

}



function productaddition($branchId) {  
$userInfo = Auth::user()->id;
$userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
$companyId=$userdetails->companyId;
$cartdata =DB::table('products')->where('products.companyId',$companyId)->get();
$count=count($cartdata);
if($count>0){
foreach ($cartdata as $cart) {
$checker =DB::table('inventory')->where('inventory.companyId',$companyId)->where('inventory.branchId',$branchId)->where('inventory.productId',$cart->productId)->get();
$counter=count($checker);
if($counter==0){
$uuid=Str::uuid()->toString();
$productdetails = new Inventory();
$productdetails->branchId = $branchId;
$productdetails->productId = $cart->productId;
$productdetails->invQuantity =0;
$productdetails->inventoryId = $uuid;
$productdetails->companyId =$companyId;
$productdetails->save();

 //inventory log
$product=$cart->productId;
$proQuantity=0;
$total=0;
$inventoryId=$uuid;
$uuid=Idgenerator();
inventorylog($branchId,$product,$proQuantity,$total,$inventoryId,$companyId,$userInfo,$uuid);

}

}
  
}

}



function productadditiontowarehousestock() {  
  $userInfo = Auth::user()->id;
  $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
  $companyId=$userdetails->companyId;
  $warehousedata =DB::table('warehouse')->where('warehouse.companyId',$companyId)->get();
  $count=count($warehousedata);
  if($count>0){
  foreach ($warehousedata as $warehouse) {
  $warehouseId = $warehouse->warehouseId;
  productadditionwarehouse($warehouseId);
  }
  }
  }




  function productadditionwarehouse($warehouseId) {  
    $userInfo = Auth::user()->id;
    $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
    $companyId=$userdetails->companyId;
    $cartdata =DB::table('products')->where('products.companyId',$companyId)->get();
    $count=count($cartdata);
    if($count>0){
    foreach ($cartdata as $cart){
    $checker =DB::table('warehouseinventory')->where('warehouseinventory.companyId',$companyId)->where('warehouseinventory.warehouseId',$warehouseId)->where('warehouseinventory.productId',$cart->productId)->get();
    $counter=count($checker);
    if($counter==0){
    $uuid=Str::uuid()->toString();
    $productdetails = new WarehouseInventory();
    $productdetails->warehouseId = $warehouseId;
    $productdetails->productId = $cart->productId;
    $productdetails->invQuantity =0;
    $productdetails->inventoryId = $uuid;
    $productdetails->companyId =$companyId;
    $productdetails->save();
    
     //inventory log
    $product=$cart->productId;
    $proQuantity=0;
    $total=0;
    $inventoryId=$uuid;
    $uuid=Idgenerator();
    inventorylog($warehouseId,$product,$proQuantity,$total,$inventoryId,$companyId,$userInfo,$uuid);
    
    }
    
    }
      
    }
    
    }







   function  vatsetupcheck(){

    $companyId = getusercompanyId();
    $levy=DB::table('vat')->where('vat.companyId',$companyId)->where('vat.vatType','Levy')->get();
    $count1=count($levy);

    $vat=DB::table('vat')->where('vat.companyId',$companyId)->where('vat.vatType','vat')->get();
    $count2=count($vat);

    if($count1>0 &&  $count1>0){

    return true;  
    }

    else{
      return false;
    }


    }


    function vatcalculator($vatstatus,$total_price,$discount){

      // $vatstatus=request('vat');

      // if($vatstatus=='yes'){
   
      //  $NHIL= 2.5/100 * $total_price ;
      //  $GTFL=2.5/100 * $total_price;
      //  $Covid=1/100 * $total_price;
      //  $VatableAmount=$NHIL+$GTFL+$Covid;
      //  $vat1= $VatableAmount+$total_price;
      //  $vat2=15/100*$vat1;
      //  $vatfinal=$vat2+$vat1;

      // }
      // else{
      //   $vatfinal = 0;
      // }
      // return $vatfinal;


      $MyArray = array();

      if($vatstatus=='yes'){
   
        // $NHIL= 2.5/100 * $total_price ;
        // $GTFL=2.5/100 * $total_price;
        // $Covid=1/100 * $total_price;
        // $VatableAmount=$NHIL+$GTFL+$Covid;
        // $vat1= $VatableAmount+$total_price;
        // $vat2=15/100*$vat1;
        // $vatfinal=$vat2+$vat1;
     
       $companyId = getusercompanyId();
       $levy=DB::table('vat')->where('vat.companyId',$companyId)->where('vat.vatType','Levy')->get();
       $count=count($levy);
       $totalLevies=0;
       $vatPercentage=0;
       if($count>0){
       foreach ($levy as $levies) {
       $rate=$levies->rate;
       $name=$levies->name;
       $cal=$levies->rate/100 * $total_price;
       $totalLevies+=$cal;
       $vatPercentage+=$rate;
       $data=array_push_assoc($MyArray,$name,$cal);
       $MyArray[$name]=$cal;
       }

      }
       $vat1= $totalLevies+$total_price;
       $vat=DB::table('vat')->where('vat.companyId',$companyId)->where('vat.vatType','vat')->first();
       $rate=$vat->rate;
       $name=$vat->name;
       $vatPercentage+=$rate;
       $vat2=$vat->rate/100*$vat1;
       $vatfinal=$vat2+$vat1;
       $vatdeductionfromtotal=$vatfinal-$total_price;
       $MyArray[$name]=$vat2;
       //$MyArray['Vat Percentage']=$vatPercentage;

         //discount
       $discountcal=$vatfinal*$discount/100;
       $discountedAmount=$vatfinal-$discountcal;
       return array($discountcal,$discountedAmount,$MyArray,$vatdeductionfromtotal,$vatPercentage);
       }
       else{
        $discountcal=$total_price*$discount/100;
        $discountedAmount=$total_price-$discountcal;
        $vatfinal=0;
        $vatPercentage=0;
        return array($discountcal,$discountedAmount,$MyArray,$vatfinal,$vatPercentage);
       }

      }

    function array_push_assoc($MyArray, $key, $value){
      $MyArray[$key] = $value;
      return $MyArray;
    }



    function getbranchforstocktransfer($branchId,$type){
     
      if($type=='branch'){
        $companyId = getusercompanyId(); 
        $products = DB::table('branches')->where('companyId',$companyId)->where('branchId','!=',$branchId)->get();
        return $products;
      }
      else{
        $companyId = getusercompanyId(); 
        $products = DB::table('branches')->where('companyId',$companyId)->get();
        return $products;
      }

    }


    function getbranchnamebyid($id){ 
      $userInfo = Auth::user()->id;
      $userdetails = DB::table('branches')->where('branchId', $id)->first();  
      $branchName=$userdetails->branchName;
      return $branchName;
      }


   function getpricing($pricing,$product){
    $price = Product::select($pricing)->where('productId',$product)->first();
    $data = json_decode($price);
    return $data->$pricing;

   }


   function getTransactionDetails($id){

    $transactions=DB::table('transactions')->where('transactionId',$id)->get();
    $count=count($transactions);

    if($count>0){
    foreach ($transactions as $trans) {
    $amount=$trans->totalAmount;
    $companyId=$trans->companyId;
    $branchId=$trans->branchId;
    $userId=$trans->userId;
    }

    $data = array(
      'amount' => $amount,
      'companyId' => $companyId,
      'branchId'=>$branchId,
      'userId'=>$userId,
      'transactionType'=>'pos'
    ); 
    
    return $data;

  }

  else{


    $transactions=DB::table('invoice')->where('invoiceId',$id)->get();
    $count=count($transactions);
  
     if($count>0){
      foreach ($transactions as $trans) {
      $amount=$trans->amount;
      $companyId=$trans->companyId;
      $branchId=$trans->branchId;
      $userId=$trans->userId;
      }

      $data = array(
        'amount' => $amount,
        'companyId' => $companyId,
        'branchId'=>$branchId,
        'userId'=>$userId,
        'transactionType'=>'invoice'
      );  
    
     return $data;
  
    }

  }

   
   }



   function getHivaPayDetails($branchId,$companyId){
    
   
    $transactions=DB::table('hivapay')->where('branchId',$branchId)->where('companyId',$companyId)->get();
    $count=count($transactions);
  
     if($count>0){
      foreach ($transactions as $trans) {
      $pK=$trans->pKey;
      $companyId=$trans->companyId;
      $branchId=$trans->branchId;
      $sK=$trans->sKey;
      $merchantId=$trans->merchantId;
      $walletId=$trans->walletId;
      }

      $data = array(
        'pKey' => $pK,
        'companyId' => $companyId,
        'branchId'=>$branchId,
        'sKey'=>$sK,
        'merchantId'=>$merchantId,
        'walletId'=>$walletId,
      );  
    
     return $data;
  
    }

   }


 
   function verifyhivapaytransaction($transactionId,$reference,$amount,$message){
    
    $transaction_id=$transactionId;
    $json = array(
        "transactionId"=>$transaction_id
        );
    $data = json_encode($json);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        
        //live
        CURLOPT_URL => "https://hivaconsulting.com/api/verifyTransactionExternal",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Cache-Control: no-cache",
       
        ),
    ));
    
     $resp = curl_exec($curl);
     $api = json_decode($resp);
     $err = curl_error($curl);
    
  
     if (!isset($api->data->info->status) || !isset($api->message) || !isset($api->data->info->transactionId) || !isset($api->data->info->reference) || !isset($api->data->info->amount)  ) {
      $message="Sorry we could not process your request.";
      return false;

    } 
     
    if ($err) {
      $message="Sorry we could not process your request. Make sure the phone number is correct,registered and you have enough balance. Try again";
      return false;
    } 
    
    else {  
     $astatus=$api->data->info->status;
     $reason=$api->message;
     $transactionId=$api->data->info->transactionId;
     $referenceId=$api->data->info->reference;
     $apiAmount=$api->data->info->amount;
     $message=$api->message;

   
    if($astatus=="COMPLETED"){

     $transactions=DB::table('hivapaylogs')->where('referenceId',$referenceId)->orwhere('transactionId',$transactionId)->where('verified',100)->get();
     $count=count($transactions);

     
      if($count==1){
        foreach ($transactions as $trans) {
        $amount=$trans->amount;
        $branchId=$trans->branchId;
        $companyId=$trans->companyId;
        $transType=$trans->transType;

        }

        

        if(empty($amount)){
         alert()->error('Account Updated succesfully', 'Success!');
         return '/pos';
        }


         $result= DB::table('hivapaylogs')->where('referenceId',$referenceId)->orwhere('transactionId',$transactionId)->update(['transactionId'=>$transactionId,'verified'=>'200','message'=>$message]);
          
          if($transType=="pos"){

            $result= DB::table('transaction')->where('transactionId',$referenceId)->where('transactionId',$transactionId)->update(['paymentMethod'=>'Hivapay','paymentStatus'=>'paid']);

            return '/pos';
          }

          if($transType=="invoice"){
            $result= DB::table('invoice')->where('invoiceId',$referenceId)->where('invoiceId',$transactionId)->update(['paymentType'=>'Hivapay','paymentStatus'=>'paid']);
            return '/pos';
          }


          if($transType=="subscriptionpayment"){
           $pdate =  date("Y-m-d h:i:s");
           $subscriptiondetails = DB::table('subscriptions')->where('subscriptionId',$reference)->update(['dateOfPayment'=>$pdate,'paymentStatus'=>1]);
          $price = DB::table('subscriptions')->where('subscriptionId',$reference)->get();
           $count=count($price);
           if($count==1){
           $subscriptiondetails = DB::table('subscriptions')->where('subscriptionId',$reference)->first();
           $ldate = $subscriptiondetails->renewalDate;
           $year= Carbon::createFromFormat('Y/m/d',$ldate)->format('Y')+1;
           $m= Carbon::createFromFormat('Y/m/d',$ldate)->format('m');
           $d= Carbon::createFromFormat('Y/m/d',$ldate)->format('d');
           $renewDate=$year.'/'.$m.'/'.$d;
           $subid = Idgenerator();
           $sub = new Subscriptions();
           $sub->subscriptionId  = $subid;
           $sub->TierSubscriptionsId =$subscriptiondetails->TierSubscriptionsId;
           $sub->dateCreated = $ldate;
           $sub->renewalDate =$renewDate;
           $sub->status =1;
           $sub->paymentStatus =0;
           $sub->amount=$subscriptiondetails->amount;
           $sub->companyId=$companyId;
           $sub->save();

              alert()->success('Account Updated succesfully', 'Success!');
             
              return '/allsubscriptions';


            }
   }


      }
     
      alert()->error('Try again later', 'Error!');
      return '/';

   }
   alert()->error('Try again later', 'Error!');
   return '/';
  }
 
   }
 


  
  
  
  function hivapayapibaseurl(){
    return 'https://hivaconsulting.com/api/'  ;
  }
  
  function paymentLinkUrl(){
    return 'https://pay.hivasolutions.com/work/pay.php'  ;
  }

  function hivapaycountry(){
    return 4 ;
  }



  function curl_request($data,$url,$bearer,$method){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    $headers =array(
        'Authorization: Bearer '.$bearer.'',
        'Content-type: application/json'
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $result = curl_exec($ch);
   
   //print_r($result);
   //return;
    if (curl_errno($ch)) {
   
        return array(false,curl_error($ch));
    }
   
    else{
   
       curl_close($ch);
       $obj = json_decode($result);
   
       return array(true,$obj);
   
    }
   
    
   }



function hivatxtlogin($apikey,$apiusername){
$url = "https://hivatxt.com/sms/index.php/Api/loginviaapi";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$data = '{"apikey":"'.$apikey.'" ,"username":"'.$apiusername.'"}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_close($curl);
$resp = curl_exec($curl);


$obj = json_decode($resp);

return $obj;





}


function userchecker($id){
$companyId = getusercompanyId();    
$userdetails = DB::table('users')->where('users.id',$id)->where('companyId',$companyId)->get();
$count=count($userdetails);
return $count;
}

function passgenerator($lenghth){
$password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
$password = substr(str_shuffle($password_string), 0, $lenghth);
return $password ;
}


function gettieramount($subId){
  $price = DB::table('subscription_tiers')->where('subscriptionTierId',$subId)->first();
  //$data = json_decode($price);
  return $price->amount;
}


function getSubcriptionDetails($id){
  $price = DB::table('subscriptions')->where('subscriptionId',$id)->get();
  $count=count($price);
  if($count==1){
   $price = DB::table('subscriptions')->where('subscriptionId',$id)->first();
   $data = array(
      'amount' => $price->amount,
      'companyId' =>$price->companyId,
      'renewalDate' =>$price->renewalDate,
 
    ); 
  return $data;

}



}



function getCompanyIdAfterRegistration(){ 
  $userdetails = DB::table('company')->orderBy('dateCreated', 'desc')->first();
  $comapanyId=$userdetails->companyId;
  return $comapanyId;
  
}



function getPricingTiers(){
  $tiers = DB::table('subscription_tiers')->get();
  return $tiers;
}


function accountTransactionsSummary($transType,$accountId){
$companyId=getusercompanyId();
$sql="SELECT *,sum(account_transactions.amount) as acctotal FROM `account_transactions` inner join accounts on accounts.accountId=account_transactions.accountId where account_transactions.transType='$transType' and account_transactions.companyId='$companyId' and account_transactions.accountId='$accountId'";
$details =DB::select(DB::raw($sql));
$count=count($details);
if($count>0){
foreach ($details as $detail) {
$total = $detail->acctotal;
if($total==0){
  $total =0;
}
return $total;
}
}
else{
  $total =0;
  return $total;
}

}




function getCompanySubcriptionDetails($feature){
$companyId=getusercompanyId();
$sub = DB::table('company')->join('subscriptions', 'subscriptions.companyId', '=', 'company.companyId')->join('subscription_tiers', 'subscription_tiers.subscriptionTierId', '=', 'subscriptions.TierSubscriptionsId')->where('company.companyId',$companyId)->orderBy('subscriptions.renewalDate','ASC')->first(); 
$date1 = strtotime($sub->dateCreated);
$date2=strtotime($sub->renewalDate);
$diff = $date2 - $date1;
$days = floor($diff / (60 * 60 * 24));

$paymentstatus= unpaidsubscription($sub->TierSubscriptionsId);
if($feature=="pos"){
if($sub->paymentStatus==0 && $paymentstatus==1 ){

$date= date("Y-m");
$details = Transaction::where('dateCreated','LIKE',"%{$date}%")->get();
$count=count($details);
if($count>30){
  $status=false;
  $message="You have exceeded your monthly quota for inputs. Please wait for the month to end or request for a higher tier subscription";
  $redirect="/allsubscriptions";
  return array($status,$message,$redirect);  
}
else{
  $status=true;
  $message="All correct";
  $redirect="/pos";
  return array($status,$message,$redirect); 
}

      
}
if($sub->paymentStatus==0 && $paymentstatus==0){
  $status=false;
  $message="You have a pending subscription to pay. Kindly proceed to pay";
  $redirect="/allsubscriptions";
  return array($status,$message,$redirect);  
}


else{
if($days==0){
  $status=false;
  $message="You subscription has expired. Kindly pay to continue to use the platfrom";
  $redirect="/allsubscriptions";
  return array($status,$message,$redirect); 
} 
}

}


if($feature=="invoice"){
  if($sub->paymentStatus==0 && $paymentstatus==1 ){

    $date= date("Y-m");
    $details = Invoice::where('created_at','LIKE',"%{$date}%")->get();
    $count=count($details);
    if($count>30){
      $status=false;
      $message="You have exceeded your monthly quota for inputs. Please wait for the month to end or request for a higher tier subscription";
      $redirect="/allsubscriptions";
      return array($status,$message,$redirect);  
    }
    else{
      $status=true;
      $message="All correct";
      $redirect="/pos";
      return array($status,$message,$redirect); 
    
    }
    
          
    }
    if($sub->paymentStatus==0 && $paymentstatus==0 ){
      $status=false;
      $message="You have a pending subscription to pay. Kindly proceed to pay";
      $redirect="/allsubscriptions";
      return array($status,$message,$redirect);  
    }
    else{
    if($days==0){
      $status=false;
      $message="You subscription has expired. Kindly pay to continue to use the platfrom";
      $redirect="/allsubscriptions";
      return array($status,$message,$redirect); 
    } 
    }

}


if($feature=="users"){

  $TierSubscriptionsId=$sub->TierSubscriptionsId;
  if($TierSubscriptionsId==1){
    $details = User::where('companyId',$companyId)->get();
    $count=count($details);
    if($count>1 ||$count==2){
      $status=false;
      $message="You have exceeded the number of user accounts you can create .Please request for a higher tier subscription";
      $redirect="/users";
      return array($status,$message,$redirect);  
    }
    else{
      $status=true;
      $message="All correct";
      $redirect="/users";
      return array($status,$message,$redirect); 
    
    }

  }

  if($TierSubscriptionsId==2){
    $details = User::where('companyId',$companyId)->get();
    $count=count($details);
    if($count>4 ||$count==5){
      $status=false;
      $message="You have exceeded the number of user accounts you can create .Please request for a higher tier subscription";
      $redirect="/users";
      return array($status,$message,$redirect);  
    }
    else{
      $status=true;
      $message="All correct";
      $redirect="/users";
      return array($status,$message,$redirect); 
    
    }
    
  }


  if($TierSubscriptionsId==3){
    $status=true;
    $message="All correct";
    $redirect="/users";
    return array($status,$message,$redirect);   
  }


}




if($feature=="branches"){

  $TierSubscriptionsId=$sub->TierSubscriptionsId;
  $details = Branch::where('companyId',$companyId)->get();
  if($TierSubscriptionsId==1){
    
    $count=count($details);
    if($count>0 ||$count==1){
      $status=false;
      $message="You have exceeded the number of user accounts you can create .Please request for a higher tier subscription";
      $redirect="/users";
      return array($status,$message,$redirect);  
    }
    else{
      $status=true;
      $message="All correct";
      $redirect="/users";
      return array($status,$message,$redirect); 
    
    }

  }

  if($TierSubscriptionsId==2){
    $count=count($details);
    if($count>2 ||$count==3){
      $status=false;
      $message="You have exceeded the number of user accounts you can create .Please request for a higher tier subscription";
      $redirect="/users";
      return array($status,$message,$redirect);  
    }
    else{
      $status=true;
      $message="All correct";
      $redirect="/users";
      return array($status,$message,$redirect); 
    
    }
    
  }


  if($TierSubscriptionsId==3){
    $status=true;
    $message="All correct";
    $redirect="/users";
    return array($status,$message,$redirect);   
  }


}




}




function unpaidsubscription($subType){
  $notpaidTypes = array("1","0");
  if(in_array($subType,$notpaidTypes)) { 
   return true;
  } else { 
    return false;
  } 
  }



function timeIntervalforTwoDates($date1,$date2){

  $diff = abs($date2 - $date1); 
 
  // To get the year divide the resultant date into
  // total seconds in a year (365*60*60*24)
  $years = floor($diff / (365*60*60*24)); 
 
  // To get the month, subtract it with years and
  // divide the resultant date into
  // total seconds in a month (30*60*60*24)
  $months = floor(($diff - $years * 365*60*60*24)
                                 / (30*60*60*24)); 
 
  // To get the day, subtract it with years and 
  // months and divide the resultant date into
  // total seconds in a days (60*60*24)
  $days = floor(($diff - $years * 365*60*60*24 - 
               $months*30*60*60*24)/ (60*60*24));
 
  // To get the hour, subtract it with years, 
  // months & seconds and divide the resultant
  // date into total seconds in a hours (60*60)
  $hours = floor(($diff - $years * 365*60*60*24 
         - $months*30*60*60*24 - $days*60*60*24)
                                     / (60*60)); 
 
  // To get the minutes, subtract it with years,
  // months, seconds and hours and divide the 
  // resultant date into total seconds i.e. 60
  $minutes = floor(($diff - $years * 365*60*60*24 
           - $months*30*60*60*24 - $days*60*60*24 
                            - $hours*60*60)/ 60); 
 
  // To get the minutes, subtract it with years,
  // months, seconds, hours and minutes 
  $seconds = floor(($diff - $years * 365*60*60*24 
           - $months*30*60*60*24 - $days*60*60*24
                  - $hours*60*60 - $minutes*60)); 

return array($days,$years,$months,$minutes,$seconds);
}