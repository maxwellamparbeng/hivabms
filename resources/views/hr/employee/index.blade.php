@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        
    @if(auth()->user()->can('hr.addEmployee') )
   
    <a href="{{ route('hr.addEmployee') }}" class="btn btn-info">Add Employee</a>  
                         @endif



                         @if(auth()->user()->can('payroll.allAllowance') )
   
                         <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">Add deductions</button>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#allowance">Add Allowance</button>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reset">Reset </button> 
                        
@endif

                         
<br>

<br>

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Employees</h5>

              <div class="modal fade" id="basicModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Add General Deductions to all employees</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form id="paymentForm" method="POST" action="{{ route('payroll.addMassDeduction') }}" enctype="multipart/form-data" >
                      @csrf
               <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="mb-3">
                    <label for="title" class="form-label">Deduction</label>
                    
            <select class="form-control" name="deductionId" >
            <option value="" >Choose deduction</option>
            @foreach($deduction as $deduct)
            <option value="{{ $deduct->deductionId }}" >{{ $deduct->deduction }}</option>
             @endforeach
             </select>
                 

                    @if ($errors->has('deductionId'))
                        <span class="text-danger text-left">{{ $errors->first('deductionId') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Type</label>   
                <select class="form-control" name="type" >
               <option value="1" >Monthly</option>
               <option value="2" >Semi-Monthly</option>
               <option value="3" >Once</option>
              </select>
                    @if ($errors->has('type'))
                        <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                    @endif
                </div>



              <div class="mb-3">
               <label for="title" class="form-label">Amount</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amount" 
                   placeholder="" >

               @if ($errors->has('amount'))
                   <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Effective Date</label>
               <input value="" 
                   type="date" 
                   class="form-control" 
                   name="effectiveDate" 
                   placeholder="" >

               @if ($errors->has('effectiveDate'))
                   <span class="text-danger text-left">{{ $errors->first('effectiveDate') }}</span>
               @endif
           </div>
           <br>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>

                    </form>


                    </div>

                  </div>
                </div>



              </div><!-- End Basic Modal-->


              <div class="modal fade" id="allowance" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Add General Allowance to all employees</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form id="paymentForm" method="POST" action="{{ route('payroll.addMassAllowance') }}" enctype="multipart/form-data" >
                      @csrf
               <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="mb-3">
                    <label for="title" class="form-label">Allowance</label>
                    
            <select class="form-control" name="allowanceId" >
            <option value="" >Choose Allowance</option>
            @foreach($allowance as $allow)
            <option value="{{ $allow->allowanceId }}" >{{ $allow->allowance }}</option>
             @endforeach
             </select>
                 

                    @if ($errors->has('allowanceId'))
                        <span class="text-danger text-left">{{ $errors->first('allowanceId') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Type</label>   
                <select class="form-control" name="type" >
               <option value="1" >Monthly</option>
               <option value="2" >Semi-Monthly</option>
               <option value="3" >Once</option>
              </select>
                    @if ($errors->has('type'))
                        <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                    @endif
                </div>



              <div class="mb-3">
               <label for="title" class="form-label">Amount</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amount" 
                   placeholder="" >

               @if ($errors->has('amount'))
                   <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Effective Date</label>
               <input value="" 
                   type="date" 
                   class="form-control" 
                   name="effectiveDate" 
                   placeholder="" >

               @if ($errors->has('effectiveDate'))
                   <span class="text-danger text-left">{{ $errors->first('effectiveDate') }}</span>
               @endif
           </div>
           <br>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>

                    </form>


                    </div>

                  </div>
                </div>







                <div class="modal fade" id="reset" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Reset Payroll</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form id="paymentForm" method="POST" action="{{ route('payroll.reset') }}" enctype="multipart/form-data" >
                      @csrf
               <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="mb-3">
                    <label for="title" class="form-label">Choose account to reset</label>
                    
            <select class="form-control" name="action" >
            <option value="allowance" >Allowance</option>
            <option value="deduction" >Deduction</option>
          
             </select>
                 

                    @if ($errors->has('action'))
                        <span class="text-danger text-left">{{ $errors->first('allowanceId') }}</span>
                    @endif
                </div>

           <br>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Reset</button>
                    </div>

                    </form>


                    </div>

                  </div>
                </div>





         

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Name</th>

                     <th scope="col">Phone number</th>

                     <th scope="col">Date of Birth</th>

                     <th scope="col">Emp Code</th>

                     <th scope="col">Hire Date</th>

                     <th scope="col">Level Education</th>

                     <th scope="col">Department</th>
                     
                     <th scope="col">Position</th>

                     <th scope="col">Salary </th>
                     
                     <th scope="col">Edit</th>

               
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>

                    <td>{{ $rec->employeeName }}</td>
                   
                    <td>{{ $rec->phoneNumber }}</td>
                    <td>{{ $rec->dateOfBirth }}</td>
                    <td>{{ $rec->empCode }}</td>
                    <td>{{ $rec->hireDate }}</td>
                    <td>{{ $rec->eduId }}</td>
                    <td>{{ $rec->deptName}}</td>
                    <td>{{ $rec->jobName}}</td>
                    <td>{{ $rec->salaryName }}</td>

                    @if(auth()->user()->can('hr.editEmployee') )
   
                    <td><a href="{{ route('hr.editEmployee', $rec->employeeId) }}" class="btn btn-info">Edit </a></td>
                       
                    <td><a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#details{{$rec->employeeId}}">View</a></td>
                    
                    @endif
                   
                      
             </tr>




             <div class="modal fade" id="details{{$rec->employeeId}}" tabindex="-1">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Payroll details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                 
                    


                    <div class='row'>

                    <div class='col-md-6'>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#singleallowance{{$rec->employeeId}}">Add Allowance</button>
                    <br>
                    <br>

                    <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                    <h5>Allowance</h5>
                    
                    <?php $allow = getEmployeeAllowance($rec->employeeId); ?>

                    @foreach ($allow as $rec)

                    <span class="name">Name :{{ $rec->allowance }}</span>
                    <br>
                    <span class="name">Amount :{{ $rec->amount }}</span>

                    <br>
                    <span class="name"><a href="{{ route('payroll.deleteAllowance', $rec->empalId) }}" class="btn btn-danger">Remove</a></span>
                    <hr>

                    @endforeach

                   

                       </div>
                       </div>
                       </div>


                       <div class='col-md-6'>

                       <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#singlededuction{{$rec->employeeId}}">Add deductions</button>
                       <br>
                    <br>
                       <div class="accordion" id="accordionExample">

                       <div class="accordion-item">

                       <h5>Deductions</h5>

                       <?php $deduct = getEmployeeDeductions($rec->employeeId); ?>

@foreach ($deduct as $rec)

<span class="name">Name :{{ $rec->deduction }}</span>
<br>
<span class="name">Amount :{{ $rec->amount }}</span>

<br>
<span class="name"><a href="{{ route('payroll.deleteDeduction', $rec->empdeId) }}" class="btn btn-danger">Remove</a></span>
<hr>

@endforeach

                       </div>
                       </div>
                       </div>

                       </div>




                    </div>

                  </div>
                </div>
                </div>
                







                <div class="modal fade" id="singleallowance{{$rec->employeeId}}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Allowance details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form id="paymentForm" method="POST" action="{{ route('payroll.addSingleAllowance') }}" enctype="multipart/form-data" >
                      @csrf
               <input type="hidden"  id="_token" value="{{ csrf_token() }}">
               <input type="hidden" name="employeeId" value="{{ $rec->employeeId}}">
                <div class="mb-3">
                    <label for="title" class="form-label">Allowance</label>
                    
            <select class="form-control" name="allowanceId" >
            <option value="" >Choose Allowance</option>
            @foreach($allowance as $allow)
            <option value="{{ $allow->allowanceId }}" >{{ $allow->allowance }}</option>
             @endforeach
             </select>
                 

                    @if ($errors->has('allowanceId'))
                        <span class="text-danger text-left">{{ $errors->first('allowanceId') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Type</label>   
                <select class="form-control" name="type" >
               <option value="1" >Monthly</option>
               <option value="2" >Semi-Monthly</option>
               <option value="3" >Once</option>
              </select>
                    @if ($errors->has('type'))
                        <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                    @endif
                </div>



              <div class="mb-3">
               <label for="title" class="form-label">Amount</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amount" 
                   placeholder="" >

               @if ($errors->has('amount'))
                   <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Effective Date</label>
               <input value="" 
                   type="date" 
                   class="form-control" 
                   name="effectiveDate" 
                   placeholder="" >

               @if ($errors->has('effectiveDate'))
                   <span class="text-danger text-left">{{ $errors->first('effectiveDate') }}</span>
               @endif
           </div>
           <br>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>

                    </form>


                    </div>

                  </div>
                </div>










                <div class="modal fade" id="singlededuction{{$rec->employeeId}}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Deduction details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form id="paymentForm" method="POST" action="{{ route('payroll.addSingleDeduction') }}" enctype="multipart/form-data" >
                      @csrf
               <input type="hidden" id="_token" value="{{ csrf_token() }}">
               <input type="hidden" name="employeeId"  value="{{ $rec->employeeId}}">

                <div class="mb-3">
                    <label for="title" class="form-label">Deduction</label>
                    
            <select class="form-control" name="deductionId" >
            <option value="" >Choose deduction</option>
            @foreach($deduction as $deduct)
            <option value="{{ $deduct->deductionId }}" >{{ $deduct->deduction }}</option>
             @endforeach
             </select>
                 

                    @if ($errors->has('deductionId'))
                        <span class="text-danger text-left">{{ $errors->first('deductionId') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Type</label>   
                <select class="form-control" name="type" >
               <option value="1" >Monthly</option>
               <option value="2" >Semi-Monthly</option>
               <option value="3" >Once</option>
              </select>
                    @if ($errors->has('type'))
                        <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                    @endif
                </div>



              <div class="mb-3">
               <label for="title" class="form-label">Amount</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amount" 
                   placeholder="" >

               @if ($errors->has('amount'))
                   <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Effective Date</label>
               <input value="" 
                   type="date" 
                   class="form-control" 
                   name="effectiveDate" 
                   placeholder="" >

               @if ($errors->has('effectiveDate'))
                   <span class="text-danger text-left">{{ $errors->first('effectiveDate') }}</span>
               @endif
           </div>
           <br>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>

                    </form>


                    </div>

                  </div>
                </div>





             @endforeach

                  
                   
                  
                
                 
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
          </div>
        </div>
      </div>
    </section>





   
    </div>

@endsection













