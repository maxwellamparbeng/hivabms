@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('payroll.payroll') )
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createpayrolls">Create New</button>
  
                         @endif

<br>
<br> 




<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Payroll</h5>
              
             




              <div class="modal fade" id="createpayrolls" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Payroll details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">



                    <form id="paymentForm" method="POST" action=" {{ route('payroll.createPayroll') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
           
          
           <div class="mb-3">
               <label for="title" class="form-label">From</label>
               <input value="" 
                   type="date" 
                   class="form-control" 
                   name="date_from" 
                   placeholder="" >

               @if ($errors->has('date_from'))
                   <span class="text-danger text-left">{{ $errors->first('date_from') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Date to</label>
               <input value="" 
                   type="date" 
                   class="form-control" 
                   name="date_to" 
                   placeholder="" >

               @if ($errors->has('date_to'))
                   <span class="text-danger text-left">{{ $errors->first('date_to') }}</span>
               @endif
           </div>


           <div class="mb-3">
                    <label for="title" class="form-label">Type</label>   
                <select class="form-control" name="type" >
               <option value="1" >Monthly</option>
               <option value="2" >Semi-Monthly</option>
              </select>
                    @if ($errors->has('type'))
                        <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                    @endif
                </div>

           


           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Add</button>

           <a href="{{ route('payroll.allDeduction') }}" class="btn btn-default">Back</a>
       </form>






                    </div>

                    </div>

                  </div>
                </div>












              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Ref No</th>

                     <th scope="col">From</th>

                     <th scope="col">To</th>

                     <th scope="col">Status</th>

                     <th scope="col">Action</th>
                     
                    
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>


                    <td>{{ $rec->ref_no }}</td>

                    <td>{{ $rec->date_from }}</td>

                    <td>{{ $rec->date_to }}</td>

                    <td>{{ $rec->status }}</td>
                  

                    @if(auth()->user()->can('payroll.payroll') )
   
                    <td>
                  
                    <a href="{{ route('payroll.attendance', $rec->ref_no) }}" class="btn btn-info">Attendance </a>
                  
                    <a href="{{ route('payroll.payroll', $rec->ref_no) }}" class="btn btn-info">Pay Roll</a>
                  
                    <a href="{{ route('payroll.payslip', $rec->ref_no) }}" class="btn btn-info">Pay Slips</a>
                 
                   

                  </td>

                    
                        @endif
                   
                      
             </tr>
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













