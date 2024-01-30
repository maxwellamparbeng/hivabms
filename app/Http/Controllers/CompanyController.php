<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Subscriptions;
use App\Models\ContactGroup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanyController extends Controller
{
    public function allbookings() 
    {
     $bookings = Booking::all();
     return view('booking.bookings')->with('records',$bookings);
    }
    public function dashboard() 
    {
        $bookings = Booking::count();
        $pending = Booking::where('bookingStatus','=','pending')->count();
        $inprogress = Booking::where('bookingStatus','=','In progress')->count();
        $completed = Booking::where('bookingStatus','=','completed')->count();
        $data = array(
            'pending'=>$pending,
            'allbookings'=>$bookings,
            'inprogress'=>$inprogress,
            'completed'=>$completed
        );
     return view('admin.index')->with($data);
   }


   public function editcompany(Company $companyId){
   return view('company.edit', [
        'user' => $companyId
      
    ]);

   }



   public function updatecompany(Company $companyId, Request $request ){

    $validatedData = $request->validate([
        'companyName' => 'required',
        'companyDescription' => 'required',
        'email' => 'required|email',
        'phoneNumber' => 'required|numeric',
        'smsApiusername' => 'required',
        'smsApikey' => 'required',
        'senderName' => 'required',
        'ProductPricing'=>'required',
        'posBarcodeScanner'=>'required',
        'subscriptionTier'=>'required',
        'tin'=>'required',
    ]);


    $companyId->update($request->only('companyName','companyDescription','phoneNumber','email','smsApiusername','smsApikey','Status','senderName','ProductPricing','posBarcodeScanner','subscriptionTier','tin'));
   

        alert()->success('Company Updated succesfully', 'Success!');
        return redirect('/allcompanies');

   }



public function allcompanies() 
    {
    $userInfo = Auth::user()->id;
    if($userInfo==5){
        $clients = DB::table('company')->get(); 
     
        $clients = DB::table('company')->join('subscription_tiers', 'subscription_tiers.subscriptionTierId', '=', 'company.subscriptionTier')->get(); 
       
       
        return view('company.company', [
            'records' => $clients,
            'tiers'=> getPricingTiers(),
          
        ]);

    }

    else{

       $companyId = getusercompanyId();
       $usertype=getusertypeInfo();
       $branchId=getuserbranchId();

       if($usertype=="Admin"){
        $clients = DB::table('company')->join('subscription_tiers', 'subscription_tiers.subscriptionTierId', '=', 'company.subscriptionTier')->where('company.companyId',$companyId)->get(); 
        return view('company.company', [
            'records' => $clients  ]);

       }


       if($usertype=="SubAdmin"){
       
        $clients = DB::table('company')->join('subscription_tiers', 'subscription_tiers.subscriptionTierId', '=', 'company.subscriptionTier')->where('company.companyId',$companyId)->get();  
        return view('company.company')->with('records',$clients);
       }

       
    }
}

public function addnewcompany() 
{
   return view('company.index');
}

public function companystore(Request $request) 
{

    if($request->hasFile('pic')){

     $validatedData = $request->validate([
            'companyName' => 'required',
            'Description' => 'required',
            'email' => 'required|email|unique:company',
            'phoneNumber' => 'required|numeric',
            'smsApiusername' => 'required',
            'smsApikey' => 'required',
            'senderName' => 'required',
            'ProductPricing'=>'required',
            'posBarcodeScanner'=>'required',
            'subscriptionTier'=>'required',
            'tin'=>'required',
        ]);
    
        $uuid = Str::uuid()->toString();
        $company = new Company();
        $company->companyName = request('companyName');
        $company->companyDescription = request('Description');
        $company->phoneNumber = request('phoneNumber');
        $company->email = request('email');
        $company->ProductPricing = request('ProductPricing');
        $company->posBarcodeScanner = request('posBarcodeScanner');
        $company->smsApiusername = request('smsApiusername');
        $company->smsApikey = request('smsApikey');
        $company->status = 'active';
        $company->companyId = $uuid;
        $company->senderName = request('senderName');
        $company->stockReduction=request('stockReduction');
        $company->natureOfBusiness=request('natureOfBusiness');
        $imageName = time().'.'.$request->pic->extension();  
        $request->pic->move(public_path('storage'), $imageName);
        $company->logo=$imageName;
        $company->subscriptionTier=request('subscriptionTier');
        $company->tin=request('tin');
        $company->save();

        //
        $ldate = date('Y/m/d');
        $year= Carbon::createFromFormat('Y/m/d',$ldate)->format('Y')+1;
        $m= Carbon::createFromFormat('Y/m/d',$ldate)->format('m');
        $d= Carbon::createFromFormat('Y/m/d',$ldate)->format('d');
        $renewDate=$year.'/'.$m.'/'.$d;
        $tieramount=gettieramount(request('subscriptionTier'));
        
        $subid = Idgenerator();
        $sub = new Subscriptions();
        $sub->subscriptionId  = $subid;
        $sub->TierSubscriptionsId =request('subscriptionTier');
        $sub->dateCreated = $ldate;
        $sub->renewalDate =$renewDate;
        $sub->status =1;
        $sub->paymentStatus =0;
        $sub->amount=$tieramount;
        $sub->companyId=getCompanyIdAfterRegistration();
        $sub->save();

        
        $cgid = Idgenerator();
        $cg = new ContactGroup();
        $cg->companyId  = getCompanyIdAfterRegistration();
        $cg->contactGroupId = $cgid;
        $cg->name ='Pos Customers';
        $cg->status =1;
        
        alert()->success('Company Added succesfully', 'Success!');
        return redirect('/allcompanies');

    }


else{

    echo 'no file';
}

}






}

