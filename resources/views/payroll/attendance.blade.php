@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

  




<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Payroll</h5>
              
      
                </div>












              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Employee name</th>

                     <th scope="col">Employee Id</th>

                     <th scope="col">Number of days worked</th>

                     <th scope="col">Action</th>
                     
                    
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>

                    <td>{{ $rec->employeeName}}</td>
                    <td>{{ $rec->employeeId }}</td> 
                    <td>{{ $rec->noDays }}</td>
               

                @if(auth()->user()->can('hr.editDepartment') )
   
   <td> <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createpayrolls">Update</button></td>
    
         @endif



             </tr>




             <div class="modal fade" id="createpayrolls" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Number of days worked</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                    <form id="paymentForm" method="POST" action=" {{ route('payroll.updateAttendance') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
         
       <input type="hidden" name='payrollId' value="{{ $rec->payrollId}}">

       <input type="hidden" name='empAttendanceId' value="{{ $rec->empAttendanceId}}">
          
           <div class="mb-3">
               <label for="title" class="form-label">Number of days</label>
               <input value="{{ $rec->noDays }}" 
                   type="text" 
                   class="form-control" 
                   name="noDays" 
                   placeholder="" >

               @if ($errors->has('noDays'))
                   <span class="text-danger text-left">{{ $errors->first('noDays') }}</span>
               @endif
           </div>




           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Update</button>

         
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













