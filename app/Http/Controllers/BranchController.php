<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
   
    public function allbranches() 
    {

        $usertype=getusertypeInfo();
        $branchId=getuserbranchId();

        if($usertype=="Admin"){
         $companyId = getusercompanyId();
         $products = DB::table('branches')->join('company','company.companyId', '=', 'branches.companyId')->where('company.companyId',$companyId)->get(); 
         return view('branch.index')->with('records',$products);

        }


        if($usertype=="SubAdmin"){
         $companyId = getusercompanyId();
         $products = DB::table('branches')->join('company','company.companyId', '=', 'branches.companyId')->where('company.companyId',$companyId)->get();  
         return view('branch.index')->with('records',$products);

        }

          if($usertype=="none"){
            $companyId = getusercompanyId();
            $products = DB::table('branches')->join('company','company.companyId', '=', 'branches.companyId')->where('company.companyId',$companyId)->get(); 
            return view('branch.index')->with('records',$products);
           }

        else{
            $products = DB::table('branches')->join('company','company.companyId', '=', 'branches.companyId')->get(); 
            //$products = DB::table('branches')->get(); 
            return view('branch.index')->with('records',$products);
        }

}


    public function addbranch() 
   {   
    return view('branch.add');
   }

    public function editbranch(Branch $branchId){
   // $companyId = getusercompanyId();
    $category = Branch::where('branchId', $branchId)->get();
    return view('branch.edit', [
        'user' => $branchId,
      
    ]);
    }


public function updatebranch(Branch $branchId, Request $request ){
    
    
    $validatedData = $request->validate([
        'name' => 'required|required|regex:/^([^0-9]*)$/',
        'phone' => 'required|numeric',
        'location' => 'required',

        
    ], [
        'name.required' => 'Name is required'
    ]);
   

       $branchId->update([
            'branchName' =>  request('name'),
            'branchPhone'=>request('phone'),
            'location'=>request('location'),
         
        ]);
    alert()->success('Branch Updated succesfully', 'Success!');
    return redirect('/allbranches');
}


public function branchstore(Request $request) 
{
      $validatedData = $request->validate([
        'name' => 'required|required|regex:/^([^0-9]*)$/',
        'phone' => 'required|numeric',
        'location' => 'required',]);

    
        $feature="branches";
        $data=getCompanySubcriptionDetails($feature);
        if(empty($data)){


        }
      elseif(!$data[0]){   
             alert()->error($data[1], 'Error!');
             return redirect($data[2]);
             }

    $uuid = Str::uuid()->toString();
    $client = new Branch();
    $client->branchName = request('name');
    $client->branchPhone = request('phone');
    $client->location = request('location');
    $client->companyId = getusercompanyId();
    $client->branchId = $uuid;
    $client->save();

   alert()->success('New branch Added succesfully', 'Success!');

    return redirect('/allbranches');
}






}
