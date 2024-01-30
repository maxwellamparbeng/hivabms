@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('debt.add') )
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createpayrolls">Add Debt</button>
  @endif


  @if(auth()->user()->can('debt.report') )
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#genreport">Generate Report</button>
  @endif



<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Debt</h5>
          
              <div class="modal fade" id="createpayrolls" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Add Debt</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


          <form id="paymentForm" method="POST" action=" {{ route('debt.store') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
         


           <div class="mb-3">
               <label for="title" class="form-label">Name</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="name" 
                   placeholder="" >

               @if ($errors->has('name'))
                   <span class="text-danger text-left">{{ $errors->first('name') }}</span>
               @endif
           </div>



           <div class="mb-3">
               <label for="title" class="form-label">Amount Owed</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amountOwed" 
                   placeholder="" >

               @if ($errors->has('amountOwed'))
                   <span class="text-danger text-left">{{ $errors->first('amountOwed') }}</span>
               @endif
           </div>



           <div class="mb-3">
               <label for="title" class="form-label">Amount Paid</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amountPaid" 
                   placeholder="" >

               @if ($errors->has('amountPaid'))
                   <span class="text-danger text-left">{{ $errors->first('amountPaid') }}</span>
               @endif
           </div>

           
           


           <div class="mb-3">
               <label for="title" class="form-label">Description</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="description" 
                   placeholder="" >

               @if ($errors->has('description'))
                   <span class="text-danger text-left">{{ $errors->first('description') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Branch</label>
               <select name="branchId" class="form-select" id="" aria-label="State">
                <option value="">Select Branch</option> 
             @foreach ($branches as $recs) 

             <option value="{{ $recs->branchId }}"> {{ $recs->branchName }}

            </option>
             @endforeach 
                   </select>
           </div>


           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Save</button>

         
       </form>
                    </div>

                    </div>

                  </div>





          <div class="modal fade" id="genreport" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Generate Report </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


          <form id="paymentForm" method="POST" action=" {{ route('debt.report') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
         

       <div class="mb-3">
 <p>Start Date</p>
<input type="date" name="from" class="form-control">
</div>

<br>


<div class="mb-3">
<p>End Date</p>
<input type="date" name="to" class="form-control">
 
</div>






           <div class="mb-3">
               <label for="title" class="form-label">Branch</label>
               <select name="branchId" class="form-select" id="" aria-label="State">
                <option value="">Select Branch</option> 
                <option value="All">All</option>
             @foreach ($branches as $recs) 
             <option value="{{ $recs->branchId }}"> {{ $recs->branchName }}
            </option>
             @endforeach 
                   </select>
           </div>



           <div class="mb-3">
               <label for="title" class="form-label">Status</label>
               <select name="status" class="form-select" id="" aria-label="State">
                <option value="">Choose Status</option> 
                <option value="All">All</option>
               <option value="paid">Paid</option>
               <option value="unpaid">Unpaid
              </option>
              <option value="cancelled">Cancelled
              </option>
                   </select>
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Report Type</label>
               <select name="reportType" class="form-select" id="" aria-label="State">
                <option value="">Select Report Type</option> 
                <option value="webview">Webview</option>
               <option value="pdf">Pdf</option>
        
              </option>
                   </select>
           </div>



           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Generate</button>

         
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
                     <th scope="col">Amount Owed</th>
                     <th scope="col">Amount Paid</th>
                     <th scope="col">Description</th>
                     <th scope="col">Branch</th>
                     <th scope="col">Status</th>
                     <th scope="col">Date</th>
                     <th scope="col">Edit</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($record as $rec)
                <tr>


               
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->amountOwed }}</td>   
                    <td>{{ $rec->amountPaid }}</td> 
                    <td>{{ $rec->description }}</td>  
                    <td>{{ $rec->branchName }}</td>
                    <td>{{ $rec->status }}</td>
                    <td>{{ $rec->dateCreated }}</td>

                    @if(auth()->user()->can('debt.edit') )
   
                      <td><a href="{{ route('debt.edit',$rec->debtId) }}" class="btn btn-info">Edit </a></td>
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













