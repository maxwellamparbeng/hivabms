<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Company;
use App\Models\ContactGroup;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportClients;
use Maatwebsite\Excel\Facades\Excel;


class ClientController extends Controller
{
   
    public function allclients() 
    {
          
      $userInfo = Auth::user()->id;
      if($userInfo==5){
        
        $clients = DB::table('clients')->get(); 
        return view('client.client')->with('records',$clients);
      }

      else{

         $companyId = getusercompanyId();
         $usertype=getusertypeInfo();
         $branchId=getuserbranchId();

         if($usertype=="Admin"){
            $records =DB::table('clients')->join('contact_group','contact_group.contactGroupId', '=', 'clients.contactgroupId')->where('clients.companyId',$companyId)->get(); 
            $groups = DB::table('contact_group')->where('companyId',$companyId)->get();
            return view('client.client',compact('records','groups'));

         }
         if($usertype=="SubAdmin"){
            $records =DB::table('clients')->join('contact_group','contact_group.contactGroupId', '=', 'clients.contactgroupId')->where('clients.companyId',$companyId)->get(); 
            $groups = DB::table('contact_group')->where('companyId',$companyId)->get();
            return view('client.client',compact('records','groups'));

         } 
         
         if($usertype=="none"){
            $records =DB::table('clients')->join('contact_group','contact_group.contactGroupId', '=', 'clients.contactgroupId')->where('clients.companyId',$companyId)->get();  
            $groups = DB::table('contact_group')->where('companyId',$companyId)->get();
            return view('client.client',compact('records','groups'));

         }    

      }
    }


    public function viewbycontactgroupId($id){
    $companyId = getusercompanyId();
    $usertype=getusertypeInfo();
    $branchId=getuserbranchId();
    //$records = DB::table('clients')->where('clients.branchId',$branchId)->get(); 

    $records =DB::table('clients')->join('contact_group','contact_group.contactGroupId', '=', 'clients.contactgroupId')->where('clients.companyId',$companyId)->where('clients.contactgroupId',$id)->get();

    $groups = DB::table('contact_group')->where('companyId',$companyId)->get();
    return view('client.client',compact('records','groups'));
    }


public function addnewclient() 
{
    $companyId = getusercompanyId();
    $groups = DB::table('contact_group')->where('companyId',$companyId)->get();
   return view('client.index',compact('groups'));
}
  
public function editclient(Client $clientId){
    $companyId = getusercompanyId();
    $groups = DB::table('contact_group')->where('companyId',$companyId)->get();
    return view('client.edit', [
        'user' => $clientId,
        'groups'=>$groups,
      
    ]);
}

 
public function updateclient(Client $clientId, Request $request ){

    $validatedData = $request->validate([
        'fullname' => 'required',
        'phoneNumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10',
        'emailAddress' => 'email',
        'gender' => 'nullable',
        'contactgroupId' => 'required',
       
    ]);

    $clientId->update($request->only('fullname','phoneNumber','emailAddress','gender','dob'));
    
   
    alert()->success('Client updated successfully', 'Success!');
    
    return redirect()->route('client.index')
        ->withSuccess(__('Client updated successfully.'));
}


public function store(Request $request) 
{
    $validatedData = $request->validate([
        'fullname' => 'required|required|regex:/^([^0-9]*)$/',
        'phoneNumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10|unique:clients',
        'emailAddress' => 'email',
        'gender' => 'required',
        'contactgroupId'=> 'required'
       
    ]);

    $branchId=getuserbranchId();
    $companyId = getusercompanyId();
    $mytime = Carbon::now();
    $uuid = Str::uuid()->toString();
    $client = new Client();
    $client->fullname = request('fullname');
    $client->phoneNumber = request('phoneNumber');
    $client->emailAddress = request('emailAddress');
    $client->gender = request('gender');
    $client->dob = request('dob');
    $client->dateCreated = $mytime->toDateTimeString();
    $client->clientId = $uuid;
    $client->companyId = $companyId;
    $client->branchId = $branchId;
    $client->contactgroupId =request('contactgroupId');
    $client->save();
    alert()->success('Client Added succesfully', 'Success!');
    return redirect('/allclients');
}

public function addClientExternal($id) 
{
   return view('client.addExternal');
}

public function storeExternalClient(Request $request) 
{
    $validatedData = $request->validate([
        'fullname' => 'required|regex:/^([^0-9]*)$/',
        'phoneNumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10|unique:clients',
        'emailAddress' => 'email',
        'gender' => 'required',
        'companyId' => 'required',
    ]);

    $pquantity = Company::where('companyId',request('companyId'))->get();
        
    $count=count($pquantity);

   if($count==0){
    return back()->with('error','Company cannot be found. Please scan and try again !');

   }

   $cg = DB::table('contact_group')->where('name', '=','Pos Customers')->where('companyId', '=',request('companyId'))->first();
   $contactGroupId=$cg->contactGroupId;

    $mytime = Carbon::now();
    $uuid = Str::uuid()->toString();
    $client = new Client();
    $client->fullname = request('fullname');
    $client->phoneNumber = request('phoneNumber');
    $client->emailAddress = request('emailAddress');
    $client->gender = request('gender');
    $client->dob = request('dob');
    $client->dateCreated = $mytime->toDateTimeString();
    $client->clientId = $uuid;
    $client->companyId = request('companyId');
    $client->branchId = "";
    $client->contactgroupId =$contactGroupId;
    $client->save();
    return back()->with('success','Information recorded succesfully !');  
}




public function exportclients()
{


$details= DB::table('clients')->get();
return Excel::download(new ExportClients($details),'Customers.xlsx');


}





// public function allContactGroup() 
//     {
//         $usertype=getusertypeInfo();
//         $branchId=getuserbranchId();

//         if($usertype=="Admin"){
//          $companyId = getusercompanyId();
//          $products = DB::table('contact_group')->where('companyId',$companyId)->get(); 
//          return view('client.contactgroup.index')->with('records',$products);
//         }

//         if($usertype=="SubAdmin"){
//          $companyId = getusercompanyId();
//          $products = DB::table('contact_group')->where('companyId',$companyId)->get();
//          return view('client.contactgroup.index')->with('records',$products);
//         }

//         if($usertype=="none"){
//             $companyId = getusercompanyId();
//             $products = DB::table('contact_group')->where('companyId',$companyId)->get(); 
//             return view('client.contactgroup.index')->with('records',$products);
//         }

//         else{
//             $products = DB::table('contact_group')->get();
//             return view('client.contactgroup.index')->with('records',$products);
//            }
//        }

//     public function addContactGroup(){   
//       return view('client.contactgroup.index');
//     }


// public function editContactGroup(ContactGroup $contactgroupId){
// $category = ContactGroup::where('contactGroupId',$contactgroupId)->get();
// return view('client.contactgroup.edit', [
// 'user' => $contactgroupId, ]);
// }


public function updateContactGroup(Request $request){

$validatedData = $request->validate([
'name' => 'required',
'contactgroupId' => 'required',
]);

if(request('name')=="Pos Customers"){
alert()->error('Group name cannot be updated', 'Error!');
return redirect('/allclients');
}

$companyId = getusercompanyId();
$subscriptiondetails = DB::table('contact_group')->where('contactgroupId',request('contactgroupId'))->where('companyId',$companyId)->update(['name'=>request('name')]);
alert()->success('Group name updated succesfully', 'Success!');
return redirect('/allclients');

}


public function contactGroupStore(Request $request) 
{
$validatedData = $request->validate([
'name' => 'required',  
]);

if(request('name')=="Pos Customers"){
    alert()->error('Group name already exist', 'Error!');
    return redirect('/allclients');
    }

$companyId = getusercompanyId();
$cgid = Idgenerator();
$cg = new ContactGroup();
$cg->companyId  =$companyId;
$cg->contactGroupId = $cgid;
$cg->name = request('name');
$cg->status =1;
$cg->save();
alert()->success('New Contact Group added succesfully','Success!');
return redirect('/allclients');

}



}
