@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
    
    @if(auth()->user()->can('account.store') )
  <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addaccount">Add Account</button>
  @endif

    

    @if(auth()->user()->can('account.addtransaction') )
  <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createpayrolls">Add Account Transaction</button>
  @endif


  @if(auth()->user()->can('account.addtransaction') )
  <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#genreport">Generate Report</button>
  @endif



<br>
<br> 

<section class="section">
      <div class="row">

      <div class="col-lg-4">

      <div class="card">
            <div class="card-body">
      <h5 class="card-title">Accounts</h5>

      <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     <th scope="col">Name</th>
                     <th scope="col">Inflow</th>
                     <th scope="col">Outflow</th>
                     <th scope="col">Total</th>
                     <th scope="col">Transaction</th>
                    
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($accounts as $rec)
                <tr>
                    <td>{{ $rec->name }}</td>
                    <td>{{ accountTransactionsSummary('inflow',$rec->accountId) }}</td> 
                    <td>{{ accountTransactionsSummary('outflow',$rec->accountId) }}</td> 
                    <td>{{ accountTransactionsSummary('inflow',$rec->accountId) - accountTransactionsSummary('outflow',$rec->accountId) }}</td>
                  
                    <td><a href="{{ route('account.TransactionsByAccount', $rec->accountId) }}" class="btn btn-info">View Transac. </a></td>
                    

                      
             </tr>
             @endforeach

                  
                   
                  
                
                 
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>


            </div>
            </div>



          </div>


        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Account Transactions</h5>
              

              <div class="modal fade" id="addaccount" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Add Account </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
        <form id="paymentForm" method="POST" action=" {{ route('account.store') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
           
              <div class="mb-3">
               <label for="title" class="form-label">Account Name</label>
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
               <label for="description" class="form-label">Description</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="description" 
                   placeholder="" >

               @if ($errors->has('title'))
                   <span class="text-danger text-left">{{ $errors->first('description') }}</span>
               @endif
           </div>

           


           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Add</button>

       </form>
   </div>

                    </div>

                    </div>

                  </div>
             


              <div class="modal fade" id="createpayrolls" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Add Account Transactions</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


          <form id="paymentForm" method="POST" action=" {{ route('account.addtransaction') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
         
     
         


           <div class="mb-3">
               <label for="title" class="form-label">Account</label>
              
               <select name="accountId" class="form-select" id="" aria-label="State">
                <option value="">Select Account</option> 
             @foreach ($accounts as $rec) 

             <option value="{{ $rec->accountId }}"> {{ $rec->name }}

            </option>
             @endforeach 
                   </select>
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Amount</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amount" 
                   placeholder="" >

               @if ($errors->has('name'))
                   <span class="text-danger text-left">{{ $errors->first('name') }}</span>
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



           <div class="mb-3">
               <label for="title" class="form-label">Transaction Type</label>
               <select name="transType" class="form-select" id="" aria-label="State">
                <option value="">Select Transaction Type</option> 
               <option value="Inflow">Inflow
               <option value="Outflow">Outflow
              </option>
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


          <form id="paymentForm" method="POST" action=" {{ route('account.transactionreport') }}" enctype="multipart/form-data" >
           
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
               <label for="title" class="form-label">Account</label>
              
               <select name="accountId" class="form-select" id="" aria-label="State">
                <option value="">Select Account</option>
                <option value="All">All</option>
             @foreach ($accounts as $rec) 

             <option value="{{ $rec->accountId }}"> {{ $rec->name }}

            </option>
             @endforeach 
                   </select>
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
               <label for="title" class="form-label">Transaction Type</label>
               <select name="transType" class="form-select" id="" aria-label="State">
                <option value="">Select Transaction Type</option> 
                <option value="All">All</option>
               <option value="Inflow">Inflow</option>
               <option value="Outflow">Outflow
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
                     <th scope="col">Amount</th>
                     <th scope="col">Transaction Type</th>
                     <th scope="col">Description</th>
                     <th scope="col">Branch</th>
                     <th scope="col">Date</th>
                     <th scope="col">Edit</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($transactions as $rec)
                <tr>
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->amount }}</td> 
                    <td>{{ $rec->transType }}</td>   
                    <td>{{ $rec->transDescription }}</td>  
                    <td>{{ $rec->branchName }}</td>
                    <td>{{ $rec->dateCreated }}</td>

                    @if(auth()->user()->can('account.editTransaction') )
                      <td><a href="{{ route('account.editTransaction', $rec->accountTransactionsId) }}" class="btn btn-info">Edit </a></td>
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













