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


class HrController extends Controller
{
    
    public function alldepartments() 
    {
     
     $usertype=getusertypeInfo();
     $branchId=getuserbranchId();


     if($usertype=="Admin"){

      $companyId = getusercompanyId();
      $dept = DB::table('department')->where('companyId',$companyId)->get(); 
      return view('hr.index')->with('records',$dept);

     }


     if($usertype=="SubAdmin"){

      $companyId = getusercompanyId();
      $dept = DB::table('department')->where('companyId',$companyId)->get(); 
      return view('hr.index')->with('records',$dept);

     }

       if($usertype=="none"){

         $companyId = getusercompanyId();
         $dept = DB::table('department')->where('companyId',$companyId)->get(); 
         return view('hr.index')->with('records',$dept);

        }

     else{

        $dept = Department::all(); 
         return view('hr.index')->with('records',$dept);

     }

    }


    public function addDepartment() {
        
        return view('hr.add');

    }
    

    public function storeDepartment(Request $request) {
        
        $validatedData = $request->validate([
            'name' => 'required',
            
        ], [
            'name.required' => 'Name is required'
        ]);
    
        $uuid = Str::uuid()->toString();
        $client = new Department();
        $client->deptName = request('name');
        $client->companyId = getusercompanyId();
        $client->deptId = $uuid;
        $client->save();
    
       alert()->success('New department Added succesfully', 'Success!');
    
        return redirect('/alldepartments');

    }


    public function editDepartment(Department $deptId){

        $companyId = getusercompanyId();
        $category = Department::where('deptId', $deptId)->get();
    
        return view('hr.edit', [
            'user' => $deptId,
            'countries'=>$category
          
        ]);
    }

    public function updateDepartment(Department $deptId, Request $request) {
    
    $deptId->update([
            'deptName' =>  request('name'),
         
        ]);
    alert()->success('Department Updated succesfully', 'Success!');
    return redirect('/alldepartments');

    }





    public function allJobs() 
    {
     
     $usertype=getusertypeInfo();
     $branchId=getuserbranchId();


     if($usertype=="Admin"){

      $companyId = getusercompanyId();
      $dept = DB::table('job')->where('companyId',$companyId)->get(); 
      return view('hr.jobindex')->with('records',$dept);

     }


     if($usertype=="SubAdmin"){

      $companyId = getusercompanyId();
      $dept = DB::table('job')->where('companyId',$companyId)->get(); 
      return view('hr.jobindex')->with('records',$dept);

     }

       if($usertype=="none"){

         $companyId = getusercompanyId();
         $dept = DB::table('job')->where('companyId',$companyId)->get(); 
         return view('hr.jobindex')->with('records',$dept);

        }

     else{

        $dept = Job::all(); 
         return view('hr.jobindex')->with('records',$dept);

     }

    }


    public function addJob() {
        
        return view('hr.addjob');

    }
    

    public function storeJob(Request $request) {
        
        $validatedData = $request->validate([
            'name' => 'required',
            
        ], [
            'name.required' => 'Name is required'
        ]);
    
        $uuid = Str::uuid()->toString();
        $client = new Job();
        $client->jobName = request('name');
        $client->companyId = getusercompanyId();
        $client->jobId = $uuid;
        $client->save();
    
       alert()->success('New department Added succesfully', 'Success!');
    
        return redirect('/allJobs');

    }


    public function editJob(Job $jobId){

        $companyId = getusercompanyId();
        $category = Job::where('jobId', $jobId)->get();
    
        return view('hr.editjob', [
            'user' => $jobId,
            'countries'=>$category
          
        ]);
    }

    public function updateJob(Job $jobId, Request $request) {
    

        
        $validatedData = $request->validate([
            'name' => 'required',
            
        ], [
            'name.required' => 'Name is required'
        ]);


        $jobId->update([
            'jobName' =>  request('name'),
         
        ]);
    alert()->success('Job Title Updated succesfully', 'Success!');
    return redirect('/allJobs');

    }








    public function allSalary() 
    {
     
     $usertype=getusertypeInfo();
     $branchId=getuserbranchId();


     if($usertype=="Admin"){

      $companyId = getusercompanyId();
      $dept = DB::table('salary')->where('companyId',$companyId)->get(); 
      return view('hr.salaryindex')->with('records',$dept);

     }


     if($usertype=="SubAdmin"){

      $companyId = getusercompanyId();
      $dept = DB::table('salary')->where('companyId',$companyId)->get(); 
      return view('hr.salaryindex')->with('records',$dept);

     }

       if($usertype=="none"){

         $companyId = getusercompanyId();
         $dept = DB::table('salary')->where('companyId',$companyId)->get(); 
         return view('hr.salaryindex')->with('records',$dept);

        }

     else{

        $dept = Salary::all(); 
         return view('hr.jobindex')->with('records',$dept);

     }

    }

    public function addSalary() {
        
        return view('hr.addsalary');

    }
    

    public function storeSalary(Request $request) {
        
        $validatedData = $request->validate([
            'name' => 'required',
            
        ], [
            'name.required' => 'Name is required'
        ]);
    
        $uuid = Str::uuid()->toString();
        $client = new Salary();
        $client->salaryName = request('name');
        $client->companyId = getusercompanyId();
        $client->salaryId = $uuid;
        $client->save();
    
       alert()->success('New salary Added succesfully', 'Success!');
    
        return redirect('/allSalary');

    }


    public function editSalary(Salary $salaryId){

       

        $companyId = getusercompanyId();
        $category = Salary::where('salaryId', $salaryId)->get();
    
        return view('hr.editsalary', [
            'user' => $salaryId,
            'countries'=>$category
          
        ]);
    }

    public function updateSalary(Salary $salaryId, Request $request) {
    
         
        $validatedData = $request->validate([
            'name' => 'required',
            
        ], [
            'name.required' => 'Name is required'
        ]);

        $salaryId->update([
            'salaryName' =>  request('name'),
         
        ]);
    alert()->success('Salary  Updated succesfully', 'Success!');
    return redirect('/allSalary');

    }



    

    public function allEmployees() 
    {
     
     $usertype=getusertypeInfo();
     $branchId=getuserbranchId();

     $salary=allsalary();
     $alldept=alldept();
     $allpositions=allpositions();
     $alledu=alledu();

     if($usertype=="Admin"){

      $companyId = getusercompanyId();
      $dept = DB::table('employee')->join('salary', 'employee.salaryId', '=', 'salary.salaryId')->join('department', 'employee.deptId', '=', 'department.deptId')->join('job', 'employee.jobId', '=', 'job.jobId')->where('employee.companyId',$companyId)->get();  

      $deductions = DB::table('deductions')->where('companyId',$companyId)->get(); 
      $allowance = DB::table('allowances')->where('companyId',$companyId)->get(); 
      $data = array(
        'salary'=>$salary,
        'dept'=>$alldept,
        'allpositions'=>$allpositions,
        'alledu'=>$alledu,
        'records'=>$dept,
        'deduction'=>$deductions,
        'allowance'=>$allowance
    );

      return view('hr.employee.index')->with($data);

     }


     if($usertype=="SubAdmin"){

      $companyId = getusercompanyId();
      $dept = DB::table('employee')->where('companyId',$companyId)->get(); 
      $deductions = DB::table('deductions')->where('companyId',$companyId)->get();
      $allowance = DB::table('allowances')->where('companyId',$companyId)->get(); 
      $data = array(
        'salary'=>$salary,
        'dept'=>$alldept,
        'allpositions'=>$allpositions,
        'alledu'=>$alledu,
        'records'=>$dept,
        'deduction'=>$deductions,
        'allowance'=>$allowance
    );

      return view('hr.employee.index')->with($data);

     }

       if($usertype=="none"){
      
         $companyId = getusercompanyId();
         $deductions = DB::table('deductions')->where('companyId',$companyId)->get();
        
         $dept = DB::table('employee')->where('companyId',$companyId)->get(); 
         $allowance = DB::table('allowances')->where('companyId',$companyId)->get(); 
         $data = array(
           'salary'=>$salary,
           'dept'=>$alldept,
           'allpositions'=>$allpositions,
           'alledu'=>$alledu,
           'records'=>$dept,
           'deduction'=>$deductions,
           'allowance'=>$allowance
       );

      return view('hr.employee.index')->with($data);

        }

     else{

      $dept = Employee::all(); 
      $data = array(
        'salary'=>$salary,
        'dept'=>$alldept,
        'allpositions'=>$allpositions,
        'alledu'=>$alledu,
        'records'=>$dept
    );

      return view('hr.employee.index')->with($data);

     }

    }

    public function addEmployee() {
    $salary=allsalary();
     $alldept=alldept();
     $allpositions=allpositions();
     $alledu=alledu();

        $data = array(
            'salary'=>$salary,
            'dept'=>$alldept,
            'allpositions'=>$allpositions,
            'alledu'=>$alledu,
            
            );
    
          return view('hr.employee.add')->with($data);

    }

    
    public function storeEmployee(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
            'email'=> 'required',
            'phoneNumber'=> 'required',
            'dateOfBirth'=> 'required',
            'empCode'=> 'required',
            'hireDate'=> 'required',
            'eduId'=> 'required',
            'jobId'=> 'required',
            'salaryId'=> 'required',
            'address'=> 'required',
            'deptId'=> 'required',
            
        ], [
            'name.required' => 'Name is required'
        ]);
    
        $uuid = Idgenerator();//Str::uuid()->toString();
        $client = new Employee();
        $client->employeeName = request('name');
        $client->email = request('email');
        $client->phoneNumber = request('phoneNumber');
        $client->dateOfBirth = request('dateOfBirth');
        $client->empCode = request('empCode');
        $client->hireDate= request('hireDate');
        $client->eduId= request('eduId');
        $client->employeeId=$uuid ;
        $client->deptId=request('deptId');
        $client->salaryId=request('salaryId');  
        $client->jobId=request('jobId');
        $client->address=request('address');
        $client->endDate='';
        $client->companyId = getusercompanyId();
        $client->save();
        alert()->success('Employee Added succesfully', 'Success!');
        return redirect('/allEmployees');

    }


    public function editEmployee(Employee $employeeId){
        
       $empId= $employeeId->employeeId;
        
       
        $companyId = getusercompanyId();

        $salary=allsalary();
        $alldept=alldept();
        $allpositions=allpositions();
        $alledu=alledu();

        $data = array(
            'salary'=>$salary,
            'dept'=>$alldept,
            'allpositions'=>$allpositions,
            'alledu'=>$alledu,
            //'records'=>$dept
        );

       $category = DB::table('employee')->join('salary', 'employee.salaryId', '=', 'salary.salaryId')->join('department', 'employee.deptId', '=', 'department.deptId')->join('job', 'employee.jobId', '=', 'job.jobId')->where('employeeId', $empId)->get();
    
     
        return view('hr.employee.edit', [
            'user' => $employeeId,
            'alledu'=>$alledu,
            'dept'=>$alldept,
            'allpositions'=>$allpositions,
            'salary'=>$salary,
            'employeeDetails'=>$category  
        ]);
    }

    public function updateEmployee(Employee $employeeId, Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
            'email'=> 'required',
            'phoneNumber'=> 'required',
            'dateOfBirth'=> 'required',
            'empCode'=> 'required',
            'hireDate'=> 'required',
            'eduId'=> 'required',
            'jobId'=> 'required',
            'salaryId'=> 'required',
            'address'=> 'required',
            'deptId'=> 'required',
            
        ]);

        $employeeId->update([
            'employeeName' => request('name'),
            'email'=> request('email'),
            'phoneNumber'=> request('phoneNumber'),
            'dateOfBirth'=> request('dateOfBirth'),
            'empCode'=> request('empCode'),
            'hireDate'=> request('hireDate'),
            'eduId'=> request('eduId'),
            'jobId'=> request('jobId'),
            'salaryId'=> request('salaryId'),
            'address'=> request('address'),
            'deptId'=> request('deptId'),
        ]);
    alert()->success('Employee records Updated succesfully', 'Success!');
    return redirect('/allEmployees');

    }




    






}