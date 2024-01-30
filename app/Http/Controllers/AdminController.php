<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\CampaignReport;
use Illuminate\Support\Facades\DB;
use SweetAlert;
use Illuminate\Support\Facades\App;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Employee;


class AdminController extends Controller
{
    
    public function allbookings() 
    {
     $bookings = Booking::all();
     return view('booking.bookings')->with('records',$bookings);
    }

    public function displayImage($filename) 
    {
        displayImage($filename) ;
    }



    public function test() 
    {

     $bookings = getsmscredentials();

     print_r($bookings);
    
    }

    public function dashboard() 
    {
     if(Auth::user()->hasRole('Super Admin'))
        {

            $campaignchart= DB::table("campaignreport")
            ->select(DB::raw("*, SUM(totalSent), campaignId"), DB::raw("DATE_FORMAT(dateCreated, '%m-%Y') new_date"),  DB::raw('YEAR(dateCreated) year, MONTH(dateCreated) month')                      )
            ->where("companyId", "=", 1)
            ->groupBy("companyId",'YEAR')
            ->get();

  
            $data = array(
                'clients'=>1,
                'campaigns'=>1,
                'smsbalance'=>1,
                'campaignchart'=>$campaignchart 
            );


        }
  
else{
    $userInfo = Auth::user()->id;
    $userdetails = DB::table('users')->join('company', 'company.companyId', '=', 'users.companyId')->where('users.id', $userInfo)->first();  
    $companyId=$userdetails->companyId;


    $campaignchart= DB::table("campaignreport")
    ->select(DB::raw("*, SUM(totalSent), campaignId"), DB::raw("DATE_FORMAT(dateCreated, '%m-%Y') new_date"),  DB::raw('YEAR(dateCreated) year, MONTH(dateCreated) month')                      )
    ->where("companyId", "=", $companyId)
    ->groupBy("companyId",'YEAR')
    ->get();

$employee=Employee::where('companyId','=',$companyId)->count();
$invoice=Invoice::where('companyId','=',$companyId)->count();
$invoice=Transaction::where('companyId','=',$companyId)->count();
$product =Product::where('companyId','=',$companyId)->count();
$smsapiusername=$userdetails->smsApiusername;
$smsapikey=$userdetails->smsApikey;
$clients = Client::where('companyId','=',$companyId)->count();
$campaigns = CampaignReport::where('companyId','=',$companyId)->count();
$smsbalance = getsmsbalance($smsapiusername,$smsapikey) ;
$data = array(
'clients'=>$clients,
'campaigns'=>$campaigns,
'smsbalance'=>$smsbalance,
'campaignchart'=>$campaignchart ,
'product'=>$product,
'invoice'=> $invoice, 
'employees'=> $employee      
);

}




return view('admin.index')->with($data);

}


   public function edit(Booking $bookingId){

    return view('booking.edit', [
        'user' => $bookingId
      
    ]);
   }



   public function update(Booking $bookingId, Request $request ){

   $bookingId->update($request->only('bookingStatus'));
    return redirect()->route('bookings.show')
        ->withSuccess(__('Booking updated successfully.'));
   }



 public function allcompanies() 
{
$companies = Company::latest()->paginate(10);
return view('users.index', compact('companies'));
}



}
