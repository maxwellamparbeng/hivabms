<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\CampaignReport;
use App\Models\Department;
use App\Models\Job;
use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use SweetAlert;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\Allowance;
use App\Models\EmployeeAllowance;
use App\Models\EmployeeDeductions;
use App\Models\Deduction;
use App\Models\Payroll;
use App\Models\EmployeeAttendance;
use PDF;


class PayrollController extends Controller
{
    
    public function allAllowance() 
    {
     
     $usertype=getusertypeInfo();
     $branchId=getuserbranchId();


     if($usertype=="Admin"){

      $companyId = getusercompanyId();
      $dept = DB::table('allowances')->where('companyId',$companyId)->get(); 
      return view('payroll.allowance.index')->with('records',$dept);

     }


     if($usertype=="SubAdmin"){

      $companyId = getusercompanyId();
      $dept = DB::table('allowances')->where('companyId',$companyId)->get(); 
      return view('payroll.allowance.index')->with('records',$dept);

     }

       if($usertype=="none"){

         $companyId = getusercompanyId();
         $dept = DB::table('allowances')->where('companyId',$companyId)->get(); 
         return view('payroll.allowance.index')->with('records',$dept);

        }

     else{

        $dept = Allowance::all(); 
         return view('payroll.allowance.index')->with('records',$dept);

     }

    }


    public function addAllowance() {
        
        return view('payroll.allowance.add');

    }
    

    public function storeAllowance(Request $request) {
        
        $validatedData = $request->validate([
           
            'allowance'=>'required',
            'description'=>'required'
            
        ]);
    
        $uuid = Str::uuid()->toString();
        $client = new Allowance();
        $client->allowance = request('allowance');
        $client->description = request('description');
        $client->companyId = getusercompanyId();
        $client->allowanceId= $uuid;
        $client->save();
    
       alert()->success('New Allowance Added succesfully', 'Success!');
    
        return redirect('/allAllowance');

    }


    public function editAllowance(Allowance $allowanceId){

        $companyId = getusercompanyId();
        $category = Allowance::where('allowanceId', $allowanceId)->get();
    
        return view('payroll.allowance.edit', [
            'user' => $allowanceId,
            'countries'=>$category
          
        ]);
    }

    public function updateAllowance(Allowance $allowanceId, Request $request) {
    
        $uuid = Str::uuid()->toString();
        $client = new Allowance();
        $client->allowance = request('allowance');
        $client->description = request('description');
        $client->companyId = getusercompanyId();
        $client->allowanceId= $uuid;
        $client->save();


    $allowanceId->update([
            'allowance' =>  request('allowance'),
            'description' =>  request('description'),  
        ]);
    alert()->success('Allowance Updated succesfully', 'Success!');
    return redirect('/allAllowance');

    }



    public function allDeduction() 
    {

     $usertype=getusertypeInfo();
     $branchId=getuserbranchId();

     if($usertype=="Admin"){

      $companyId = getusercompanyId();
      $dept = DB::table('deductions')->where('companyId',$companyId)->get(); 
      return view('payroll.deductions.index')->with('records',$dept);

     }

     if($usertype=="SubAdmin"){

      $companyId = getusercompanyId();
      $dept = DB::table('deductions')->where('companyId',$companyId)->get(); 
      return view('payroll.deductions.index')->with('records',$dept);

     }

       if($usertype=="none"){

         $companyId = getusercompanyId();
         $dept = DB::table('deductions')->where('companyId',$companyId)->get(); 
         return view('payroll.deductions.index')->with('records',$dept);
        }

     else{

        $dept = Job::all(); 
         return view('payroll.deductions.index')->with('records',$dept);

     }

    }


    public function addDeduction() {
    
        return view('payroll.deductions.add');

    }
    

    public function storeDeduction(Request $request) {
        
        $validatedData = $request->validate([
            'deduction'=>'required',
            'description'=>'required'
            
        ]);
    
        $uuid = Str::uuid()->toString();
        $client = new Deduction();
        $client->deduction = request('deduction');
        $client->description = request('description');
        $client->companyId = getusercompanyId();
        $client->deductionId = $uuid;
        $client->save();
        alert()->success('New Deduction Added succesfully', 'Success!');
        return redirect('/allDeduction');

    }


    public function editDeduction(Deduction $deductionId){
        $companyId = getusercompanyId();
        $category = Deduction::where('deductionId', $deductionId)->get();
        return view('payroll.deductions.edit', [
            'user' => $deductionId,
            'countries'=>$category
        ]);
    }


    public function updateDeduction(Deduction $deductionId, Request $request) {
        $validatedData = $request->validate([
            'deduction'=>'required',
            'description'=>'required'
        ]);
        $deductionId->update([
            'deduction' =>  request('deduction'),
            'description' =>  request('description'),
        ]);
        alert()->success('Deduction Updated succesfully', 'Success!');
        return redirect('/allDeduction');
    }


    public function addMassDeduction(Request $request) {
        $validatedData = $request->validate([
            'deductionId'=>'required',
            'amount'=>'required|numeric',
            'type'=>'required',
            'effectiveDate'=>'nullable',
            'action'=>'required',  
        ]);

        $action=request('action');

         if($action=='Deduction') {

            $branchId=getuserbranchId();
            $uuid = Str::uuid()->toString();
            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $empdata = DB::table('employee')->where('companyId',$companyId)->get();
             $count=count($empdata);
            if($count>0){
                foreach ($empdata as $emp) {
                    $empdeduction = DB::table('employee_deductions')->where('deductionId',request('deductionId'))->where('employeeId',$emp->employeeId)->get();
                   $count=count($empdeduction);
                    if($count==0){
                        $mytime = Carbon::now();
                        $uuid = Str::uuid()->toString();
                        $client = new EmployeeDeductions();
                        $client->amount = request('amount');
                        $client->type = request('type') ;
                        $client->empdeId =$uuid;
                        $client->deductionId = request('deductionId');
                        $client->employeeId = $emp->employeeId;
                        $client->effectiveDate = request('effectiveDate');
                        $client->dateCreated = $mytime->toDateTimeString();
                        $client->save();
                       
                    }
                   } 
                   
                   
                   alert()->success('New Deduction Added succesfully', 'Success!');
                   return redirect('/allEmployees');
    
    
            }
            else{
                alert()->info('No employee record available', 'Error!');
                return redirect('/allEmployees'); 
            }





         }


         if($action=='Allowance') {

            $branchId=getuserbranchId();
            $uuid = Str::uuid()->toString();
            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $empdata = DB::table('employee')->where('companyId',$companyId)->get();
             $count=count($empdata);
            if($count>0){
                foreach ($empdata as $emp) {
                    $empdeduction = DB::table('employee_allowance')->where('allowanceId',request('deductionId'))->where('employeeId',$emp->employeeId)->get();
                   $count=count($empdeduction);
                    if($count==0){
                        $mytime = Carbon::now();
                        $uuid = Str::uuid()->toString();
                        $client = new EmployeeAllowance();
                        $client->amount = request('amount');
                        $client->type = request('type') ;
                        $client->empalId =$uuid;
                        $client->allowanceId = request('deductionId');
                        $client->employeeId = $emp->employeeId;
                        $client->effectiveDate = request('effectiveDate');
                        $client->dateCreated = $mytime->toDateTimeString();
                        $client->save();
                       
                    }
                   } 
                   
                   
                   alert()->success('New Allowance Added succesfully', 'Success!');
                   return redirect('/allEmployees');
    
    
            }
            else{
                alert()->info('No employee record available', 'Error!');
                return redirect('/allEmployees'); 
            }

        }

         
       
    }


    public function addMassAllowance(Request $request) {
        $validatedData = $request->validate([
            'allowanceId'=>'required',
            'amount'=>'required|numeric',
            'type'=>'required',
            'effectiveDate'=>'required', 
        ]);
        $action='Allowance';
        if($action=='Allowance') {

            $branchId=getuserbranchId();
            $uuid = Str::uuid()->toString();
            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $empdata = DB::table('employee')->where('companyId',$companyId)->get();
            $count=count($empdata);
            if($count>0){
                foreach ($empdata as $emp) {
                    $empdeduction = DB::table('employee_allowances')->where('allowanceId',request('allowanceId'))->where('employeeId',$emp->employeeId)->get();
                   $count=count($empdeduction);
                    if($count==0){
                        $mytime = Carbon::now();
                        $uuid = Str::uuid()->toString();
                        $client = new EmployeeAllowance();
                        $client->amount = request('amount');
                        $client->type = request('type') ;
                        $client->empalId =$uuid;
                        $client->allowanceId = request('allowanceId');
                        $client->employeeId = $emp->employeeId;
                        $client->effectiveDate = request('effectiveDate');
                        $client->dateCreated = $mytime->toDateTimeString();
                        $client->save();
                       
                    }
                   } 
                   
                   
                   alert()->success('New Allowance Added succesfully', 'Success!');
                   return redirect('/allEmployees');
    
    
            }
            else{
                alert()->info('No employee record available', 'Error!');
                return redirect('/allEmployees'); 
            }

        }

         
       
    }






    public function addSingleDeduction(Request $request) {
        $validatedData = $request->validate([
            'deductionId'=>'required',
            'amount'=>'required|numeric',
            'type'=>'required',
            'effectiveDate'=>'nullable',
            'employeeId'=>'required',
            
        ]);

        $action='Deduction';

         if($action=='Deduction') {

            $branchId=getuserbranchId();
            $uuid = Str::uuid()->toString();
            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $empdata = DB::table('employee')->where('companyId',$companyId)->where('employeeId',request('employeeId'))->get();
             $count=count($empdata);
            if($count>0){
                foreach ($empdata as $emp) {
                    $empdeduction = DB::table('employee_deductions')->where('deductionId',request('deductionId'))->where('employeeId',$emp->employeeId)->get();
                   $count=count($empdeduction);
                    if($count==0){
                        $mytime = Carbon::now();
                        $uuid = Str::uuid()->toString();
                        $client = new EmployeeDeductions();
                        $client->amount = request('amount');
                        $client->type = request('type') ;
                        $client->empdeId =$uuid;
                        $client->deductionId = request('deductionId');
                        $client->employeeId = $emp->employeeId;
                        $client->effectiveDate = request('effectiveDate');
                        $client->dateCreated = $mytime->toDateTimeString();
                        $client->save();
                       
                    }
                   } 
                   
                   
                   alert()->success('New Deduction Added succesfully', 'Success!');
                   return redirect('/allEmployees');
    
    
            }
            else{
                alert()->info('No employee record available', 'Error!');
                return redirect('/allEmployees'); 
            }





         }

         
       
    }


    public function addSingleAllowance(Request $request) {
        $validatedData = $request->validate([
            'allowanceId'=>'required',
            'amount'=>'required|numeric',
            'type'=>'required',
            'effectiveDate'=>'required', 
            'employeeId'=>'required',
        ]);
        $action='Allowance';
        if($action=='Allowance') {

            $branchId=getuserbranchId();
            $uuid = Str::uuid()->toString();
            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $empdata = DB::table('employee')->where('companyId',$companyId)->where('employeeId',request('employeeId'))->get();
            $count=count($empdata);
            if($count>0){
                foreach ($empdata as $emp) {
                    $empdeduction = DB::table('employee_allowances')->where('allowanceId',request('allowanceId'))->where('employeeId',$emp->employeeId)->get();
                   $count=count($empdeduction);
                    if($count==0){
                        $mytime = Carbon::now();
                        $uuid = Str::uuid()->toString();
                        $client = new EmployeeAllowance();
                        $client->amount = request('amount');
                        $client->type = request('type') ;
                        $client->empalId =$uuid;
                        $client->allowanceId = request('allowanceId');
                        $client->employeeId = $emp->employeeId;
                        $client->effectiveDate = request('effectiveDate');
                        $client->dateCreated = $mytime->toDateTimeString();
                        $client->save();
                       
                    }
                   } 
                   
                   
                   alert()->success('New Allowance Added succesfully', 'Success!');
                   return redirect('/allEmployees');
    
    
            }
            else{
                alert()->info('No employee record available', 'Error!');
                return redirect('/allEmployees'); 
            }

        }

         
       
    }





    public function reset(Request $request) {
        $validatedData = $request->validate([
            'action'=>'required', 
        ]);

        $action=request('action');

        if($action=='allowance') {

            $branchId=getuserbranchId();
            $uuid = Str::uuid()->toString();
            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $res=EmployeeAllowance::where('companyId',$companyId)->delete();

        }

        if($action=='deduction') {

            $branchId=getuserbranchId();
            $uuid = Str::uuid()->toString();
            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $res=EmployeeDeductions::where('companyId',$companyId)->delete();

        }

         
       
    }

    public function deleteDeduction($id) {
     $res=EmployeeDeductions::where('empdeId',$id)->delete(); 
     alert()->success('Deduction deleted succesfully', 'Success!');
     return redirect('/allEmployees');
    }


    public function deleteAllowance($id) {
        $res=EmployeeAllowance::where('empalId',$id)->delete(); 
        alert()->success('Allowance deleted succesfully', 'Success!');
        return redirect('/allEmployees');
    }


    public function allpayroll() 
    {

     $usertype=getusertypeInfo();
     $branchId=getuserbranchId();

     if($usertype=="Admin"){

      $companyId = getusercompanyId();
      $dept = DB::table('payroll')->where('companyId',$companyId)->get(); 
      return view('payroll.index')->with('records',$dept);

     }

     if($usertype=="SubAdmin"){

      $companyId = getusercompanyId();
      $dept = DB::table('payroll')->where('companyId',$companyId)->get(); 
      return view('payroll.index')->with('records',$dept);

     }

       if($usertype=="none"){

         $companyId = getusercompanyId();
         $dept = DB::table('payroll')->where('companyId',$companyId)->get(); 
      return view('payroll.index')->with('records',$dept);
        }

     else{

        $dept = Payroll::all(); 
        return view('payroll.index')->with('records',$dept);
        

     }

    }


    public function addpayroll() {

        return view('payroll.add');

    }


    public function attendance($id) {

       $attendance =DB::table('employee')->join('employeeattendance','employeeattendance.employeeId', '=', 'employee.employeeId')->where('employeeattendance.payrollId',$id)->get();
        return view('payroll.attendance')->with('records',$attendance);

    }


    public function updateAttendance(Request $request) {
        $validatedData = $request->validate([
            'noDays'=>'required|numeric', 
            'payrollId'=>'required', 
            'empAttendanceId'=>'required', 
        ]);

            $cart = EmployeeAttendance::find(request('empAttendanceId'));
            $cart->noDays = request('noDays');
            $cart->save();
            
            alert()->success('Attendance updated succesfully', 'Success!');
            return back()->with('success','Information recorded succesfully !');  
   
   
    }

    public function createPayroll(Request $request) {

    $validatedData = $request->validate([
            'date_from'=>'required', 
            'date_to'=>'required', 
            'type'=>'required', 
        ]);

            $ref_no=date('Y') .'-'. mt_rand(1,9999);
            $uuid = Str::uuid()->toString();
            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $mytime = Carbon::now();
            $uuid = Str::uuid()->toString();
            $client = new Payroll();
            $client->id = $uuid;
            $client->ref_no = $ref_no;
            $client->date_from = request('date_from');
            $client->date_to = request('date_to');
            $client->type = request('type');
            $client->status = 0;
            $client->companyId =$companyId;
            $client->save();

            $empdata = DB::table('employee')->where('companyId',$companyId)->get();
            $count=count($empdata);
            if($count>0){
                foreach ($empdata as $emp) {
                
               
                        $mytime = Carbon::now();
                        $uuid = Str::uuid()->toString();
                        $client = new EmployeeAttendance();
                        $client->empAttendanceId =$uuid;
                        $client->employeeId = $emp->employeeId;
                        $client->payrollId = $ref_no ;
                        $client->noDays = 22;
                        $client->save();
                       
                    

                       calculatepayroll($emp->employeeId,$ref_no);
               
                   } 
                   
                   
                   alert()->success('New Payroll created succesfully', 'Success!');
                  return redirect('/allpayroll');
    
    
            }


     
    }


    public function payroll($id) {

        $attendance =DB::table('employee')->join('employeeattendance','employeeattendance.employeeId', '=', 'employee.employeeId')->join('payroll','payroll.ref_no', '=', 'employeeattendance.payrollId')->where('employeeattendance.payrollId',$id)->get();
         return view('payroll.payroll')->with('records',$attendance);
 
     }


     public function payslip($id) {

        $attendance =DB::table('employee')->join('employeeattendance','employeeattendance.employeeId', '=', 'employee.employeeId')->join('payroll','payroll.ref_no', '=', 'employeeattendance.payrollId')->join('job','job.jobId', '=', 'employee.jobId')->where('employeeattendance.payrollId',$id)->get()->toArray();
        return view('payroll.payslip')->with('records',$attendance);
 
     }



     public function attendancePdf($id) {

        $attendance =DB::table('employee')->join('employeeattendance','employeeattendance.employeeId', '=', 'employee.employeeId')->where('employeeattendance.payrollId',$id)->get()->toArray();;
        $data = array(
        'records'=>$attendance,
         );
        $pdf = PDF::loadView('payroll.attendancepdf',$data)->setOptions(['defaultFont' => 'sans-serif']);
     // return $pdf->download('itsolutionstuff.pdf');
        return $pdf->stream('Profile.pdf', array('Attachment'=>0));
     }


     public function payrollpdf($id) {

        $attendance =DB::table('employee')->join('employeeattendance','employeeattendance.employeeId', '=', 'employee.employeeId')->join('payroll','payroll.ref_no', '=', 'employeeattendance.payrollId')->where('employeeattendance.payrollId',$id)->get()->toArray();
        $data = array(
        'records'=>$attendance,
         );
        $pdf = PDF::loadView('payroll.payrollpdf',$data)->setOptions(['defaultFont' => 'sans-serif']);
     // return $pdf->download('itsolutionstuff.pdf');
        return $pdf->stream('Payroll.pdf', array('Attachment'=>0));
     }


     
     public function incometax(){

       $employeeId='a4c506f4-e992-4f45-9cf4-adedda4a7c15';
        $payrollId='2023-2593';
       
    //$payroll=calculatepayroll($employeeId,$payrollId);

    displaypayrolldetails($employeeId,$payrollId);
       // print_r($payroll);

       //$payroll['deduction']->sum('amount');

    
    }



}