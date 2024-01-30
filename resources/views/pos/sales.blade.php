@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">



    <div class="row">
      
          <div class="col-md-12 ">



          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Generate  Sales report</h5>

   <!-- Bordered Tabs -->
   <ul class="nav nav-tabs nav-tabs-bordered">

<li class="nav-item">
  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#sales">Report By sales</button>
</li>

<li class="nav-item">
  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#product">Report by product</button>
</li>

<li class="nav-item">
  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#customer">Report by customer</button>
</li>

<li class="nav-item">
  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allsales">All sales</button>
</li>

</ul>
<div class="tab-content pt-2">

<div class="tab-pane fade show active profile-overview" id="sales">
  <h5 class="card-title"></h5>

  <!-- Floating Labels Form -->
  <form name="" action="{{ route('pos.salesdaterange') }}" method="POST" class="row g-3">
               
              @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="reportquested" value="BySales"> 
         
                <div class="col-md-4">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   
                  <div class="row mb-4">
                  <label for="inputDate" class="col-sm-2 col-form-label">Start Date</label>
                  <div class="col-sm-10">
                    <input type="date" name="from" class="form-control">
                  </div>
                </div>


                  </div>
                </div>
                </div>


                <div class="col-md-4">
                  <div class="form-floating mb-3">
                 
                  <div class="row mb-3">
                  <label for="inputDate" class="col-sm-2 col-form-label">End Date</label>
                  <div class="col-sm-10">
                    <input type="date" name="to" class="form-control">
                  </div>
                </div>

                  
                  </div>
                </div>



                <label for="inputDate" class="col-sm-1 col-form-label">Branch</label>
                 

                <div class="col-md-2">
                
                
                <div class="form-floating mb-3">
                
                <select name="branch" class="form-select" id="js-example-basic-single" aria-label="State">
                <option value="">Select Branch</option> 
 <option value="All">All</option>
 @foreach ($branch as $key => $value) 

<option value="{{ $key }}"> {{ $value }}

</option>
  @endforeach 
                   </select>

                </div>
              </div>

              <div class="col-md-1">
              </div>

              <?php
                
                $usertype=getusertypeInfo();
                
                ?> 

              <div class="col-md-1">
                  <div class="form-floating">
                
                  <label for="inputDate" class="">User</label>
                  </div>
                </div>

              
                 

                 <div class="col-md-2">
                 
                 
                 <div class="form-floating mb-3">

                

          @if($usertype=="none")

            <select name="userList" required class="form-select" id="js-example-basic-single" aria-label="State">
                 
             
                 <option value="">Select User</option> 
                 <option value="{{auth()->user()->id}}">Self</option>

         </select>
        
          @else
          <select name="userList" required class="form-select" id="js-example-basic-single" aria-label="State">
                 
                 
                 <option value="">Select User</option> 
                 <option value="All">All</option>
                   @foreach ($userList as $key => $value) 
    
                   <option value="{{ $key }}"> {{ $value }}
    
                  </option>
                  @endforeach 
                       </select>
 
          @endif
                 
             
 
                 </div>
               </div>

               


                <div class="col-md-2">
                  <div class="form-floating">
                
                  <button type="submit" class="btn btn-primary">Generate</button>
                  </div>
                </div>
                
              </form><!-- End floating Labels Form -->



</div>

<div class="tab-pane fade profile-edit pt-3" id="product">


  <!-- Floating Labels Form -->
  <form name="" action="{{ route('pos.salesdaterange') }}" method="POST" class="row g-3">
               
              @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="reportquested" value="ByProducts">  


                <div class="col-md-4">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   
                  <div class="row mb-4">
                  <label for="inputDate" class="col-sm-2 col-form-label">Start Date</label>
                  <div class="col-sm-10">
                    <input type="date" name="from" class="form-control">
                  </div>
                </div>


                  </div>
                </div>
                </div>


                <div class="col-md-4">
                  <div class="form-floating mb-3">
                 
                  <div class="row mb-3">
                  <label for="inputDate" class="col-sm-2 col-form-label">End Date</label>
                  <div class="col-sm-10">
                    <input type="date" name="to" class="form-control">
                  </div>
                </div>

                  
                  </div>
                </div>



                <label for="inputDate" class="col-sm-1 col-form-label">Product</label>
                 

                <div class="col-md-2">
                
                
                <div class="form-floating mb-3">
                
                <select name="product" class="form-select" id="js-example-basic-single" aria-label="State">
                <option value="">Select Product</option> 
             @foreach ($product as $key => $value) 

             <option value="{{ $key }}"> {{ $value }}

            </option>
             @endforeach 
                   </select>

                </div>
              </div>

              <div class="col-md-1">
              </div>

              <?php
                
                $usertype=getusertypeInfo();
                
                ?> 

          
                <div class="col-md-2">
                  <div class="form-floating">
                
                  <button type="submit" class="btn btn-primary">Generate</button>
                  </div>
                </div>
                
              </form><!-- End floating Labels Form -->

 

</div>

<div class="tab-pane fade pt-3" id="customer">

 <!-- Floating Labels Form -->
 <form name="" action="{{ route('pos.salesdaterange') }}" method="POST" class="row g-3">
               
               @csrf
             <input type="hidden" id="_token" value="{{ csrf_token() }}">


             <input type="hidden" name="reportquested" value="ByCustomers">  

                 <div class="col-md-4">
                   <div class="col-md-12">
                   <div class="form-floating mb-3">
                    
                   <div class="row mb-4">
                   <label for="inputDate" class="col-sm-2 col-form-label">Start Date</label>
                   <div class="col-sm-10">
                     <input type="date" name="from" class="form-control">
                   </div>
                 </div>
 
 
                   </div>
                 </div>
                 </div>
 
 
                 <div class="col-md-4">
                   <div class="form-floating mb-3">
                  
                   <div class="row mb-3">
                   <label for="inputDate" class="col-sm-2 col-form-label">End Date</label>
                   <div class="col-sm-10">
                     <input type="date" name="to" class="form-control">
                   </div>
                 </div>
 
                   
                   </div>
                 </div>
 
 
 
                 <label for="inputDate" class="col-sm-1 col-form-label">Customer phone number</label>
                  
 
                 <div class="col-md-2">
                 
                 
                 <div class="form-floating mb-3">
                 
                 <input type="text" name="customer" class="form-control">
 
                 </div>
               </div>
 
               <div class="col-md-1">
               </div>
 
               <?php
                 
                 $usertype=getusertypeInfo();
                 
                 ?> 
 
 
 
                 <div class="col-md-2">
                   <div class="form-floating">
                 
                   <button type="submit" class="btn btn-primary">Generate</button>
                   </div>
                 </div>
                 
               </form><!-- End floating Labels Form -->







</div>





<div class="tab-pane fade pt-3" id="allsales">

 <!-- Floating Labels Form -->
 <form name="" action="{{ route('pos.salesdaterange') }}" method="POST" class="row g-3">
               
               @csrf
             <input type="hidden" id="_token" value="{{ csrf_token() }}">


             <input type="hidden" name="reportquested" value="ByAllsales">  

                 <div class="col-md-4">
                   <div class="col-md-12">
                   <div class="form-floating mb-3">
                    
                   <div class="row mb-4">
                   <label for="inputDate" class="col-sm-2 col-form-label">Start Date</label>
                   <div class="col-sm-10">
                     <input type="date" name="from" class="form-control">
                   </div>
                 </div>
 
 
                   </div>
                 </div>
                 </div>
 
 
                 <div class="col-md-4">
                   <div class="form-floating mb-3">
                  
                   <div class="row mb-3">
                   <label for="inputDate" class="col-sm-2 col-form-label">End Date</label>
                   <div class="col-sm-10">
                     <input type="date" name="to" class="form-control">
                   </div>
                 </div>
 
                   
                   </div>
                 </div>
 
 

 
               <div class="col-md-1">
               </div>
 
               <?php
                 
                 $usertype=getusertypeInfo();
                 
                 ?> 
 
             

 
 
                 <div class="col-md-2">
                   <div class="form-floating">
                 
                   <button type="submit" class="btn btn-primary">Generate</button>
                   </div>
                 </div>
                 
               </form><!-- End floating Labels Form -->







</div>



</div><!-- End Bordered Tabs -->
























            </div>
      

          </div>



          </div>
          </div>





      <div class="row">
        <div class="col-lg-12">


        
        
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Transactions</h5>
              



            



              <div class="row">

              <div class="col-md-2">
             
                <div class="card info-card sales-card">

<div class="filter">
  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
 
</div>



<div class="card-body">
  <h5 class="card-title">Sales<span></span></h5>

  <div class="d-flex align-items-center">
    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
      <i class="bi bi-wallet2"></i>
    </div>
    <div class="ps-3">
      <h6>{{ $totalsales }}</h6>
      <span class="text-success small pt-1 fw-bold"></span>This Month<span class="text-muted small pt-2 ps-1"></span>

    </div>
  </div>
</div>

</div>








            
            </div>




              
              <div class="col-md-5">
             
              <form name="" action="{{ route('pos.searchtransaction') }}" method="POST" class="row g-3">
              @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                 <div class="form-floating mb-3">
                 
                
                 <p>Search by Customer name,phone number or receipt id</p> 
                
                 <input value="" 
                        type="text" 
                        class="form-control" 
                        name="searchquery" id="query"
                        placeholder="Customer name,phone number or receipt id" required>

 
                 </div>
               </div>

               <div class="col-md-2">
                  <div class="form-floating">
                <br>
                <br>
                  <button type="submit" class="btn btn-primary">Find</button>
                  </div>
                </div>
                     </form>
               </div>


              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  
                  <th scope="col">Transaction Id</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Phone number</th>
                    
                    <th scope="col">Total Amount</th>
                    <th scope="col">Payment method</th>
                    <th scope="col">Address</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

               
               
                @foreach ($details as $rec)
<tr>
    <th scope="row">{{ $rec->transactionId }}</th>
    <td>{{ $rec->customer }}</td>
    <td>{{ $rec->email }}</td>
    <td>{{ $rec->phone }}</td>
    <td>{{ $rec->totalAmount }}</td>
    <td>{{ $rec->paymentMethod}}</td>
    <td>{{ $rec->address}}</td>
    <td>{{ $rec->created_at}}</td>
    <td>{{ $rec->status}}</td>
    
  <td>

  <div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu">
    
  @if(auth()->user()->can('pos.viewtransactiondetails') )
    
  <a class="dropdown-item" href="{{route('pos.viewtransactiondetails',$rec->transactionId)}}">Info</a>
       @endif


       @if(auth()->user()->can('pos.editreceipt') )
 <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reset{{ $rec->transactionId  }}">Edit Receipt</a>
 @endif
  
   
       @if(auth()->user()->can('pos.viewreceipt') )
   
    <a class="dropdown-item" href="{{ route('pos.viewreceipt',$rec->transactionId)}}">Receipt</a>
    @endif
    
    @if(auth()->user()->can('pos.cancelreceipt') )
    
    @if($rec->status=="COMPLETED")
   
    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#basicModal{{ $rec->transactionId }}">Cancel Invoice</a>
   @endif
  
    @endif


    @if(getcompanyhivapaystatus()=="yes")
   
    
   <a class="dropdown-item" href="{{ route('pay.invoice',$rec->transactionId)}}">Receive Payment</a>
   
   @endif


    @if(getcompanyhivapaystatus()=="yes")
   
   <input type="hidden" value="{{ route('pay.invoice',$rec->transactionId)}}" id="myInput">
   <button class="dropdown-item" onclick="copytoclipboard()">Copy Payment Link</button>
   @endif

   
   @if(auth()->user()->can('pos.viewTransactionLog') )
    <a class="dropdown-item" href="{{ route('pos.viewTransactionLog',$rec->transactionId)}}">View Log</a>
    @endif


    

  </div>

    
  </td>



  <div class="modal fade" id="reset{{$rec->transactionId }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Invoice Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

  <form name="" action="{{ route('pos.editreceipt') }}" method="POST" class="row g-3">
              @csrf
             <input type="hidden" id="_token" value="{{ csrf_token() }}">  
             <input type="hidden" name="invoiceId" value="{{ $rec->transactionId}}"  class="form-control" id="floatingEmail" placeholder="Your Email">
             
              <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" name="name" value="{{ $rec->customer }}" class="form-control" id="floatingName" placeholder="Your Name">
                    <label for="floatingName">Customer name</label>
                  </div>
                </div>
                <br>
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="email" name="email" value="{{ $rec->email }}" class="form-control" id="floatingEmail" placeholder="Your Email">
                    <label for="floatingEmail">Customer Email</label>
                  </div>
                </div>
                
                <br>

                <div class="col-12">
                  <div class="form-floating">
                    <textarea name="address" class="form-control" value="" placeholder="Address" id="floatingTextarea" style="height: 100px;">{{ $rec->address }}</textarea>
                    <label for="floatingTextarea">Address</label>
                  </div>
                </div>

                <br>

                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="phone" name="phone" value="{{ $rec->phone }}" class="form-control" id="floatingEmail" placeholder="Your Email">
                    <label for="floatingEmail">Phone</label>
                  </div>
                </div>


              <br>

                <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="paymentType" class="form-select" id="floatingSelect" aria-label="State">
                
                  <option value="{{ $rec->paymentMethod}}" >{{ $rec->paymentMethod}}</option>
                  <option value="cash" >Cash</option>
                  <option value="mobile money" >Mobile money</option>
                  <option value="bank Transfer" >Bank Transfer</option>
                  <option value="Cheque" >Cheque</option>
                  <option value="other" >Other</option>




                   </select>
                   <label for="floatingSelect">Payment method</label>
                 </div>

                  </div>
                </div>

                <br>
                
                <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="paymentStatus" class="form-select" id="floatingSelect" aria-label="State">
                   <option value="{{ $rec->paymentStatus}}" >{{ $rec->paymentStatus}}</option>
                  <option value="unpaid" >Unpaid</option>
                  <option value="paid" >Paid</option>
                   </select>
                   <label for="floatingSelect">Payment Status</label>
                 </div>

                  </div>
                </div>

                <br>

                <div class="col-12">
                  <div class="form-floating">
                    <textarea name="note" value="" class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;">{{ $rec->note}}</textarea>
                    <label for="floatingTextarea">Receipt note</label>
                  </div>
                </div>
                
                <br>
              
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Update Receipt</button>
                 
                </div>
              </form><!-- End floating Labels Form -->
                    
         


                    </div>

                  </div>
                </div>
                </div>




          <div class="modal fade" id="basicModal{{ $rec->transactionId }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Cancel Invoice ?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                     <p>are you want to cancel this invoice ? Note that this action can not be reversed </p>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <a class="btn btn-danger" href="{{ route('pos.cancelreceipt',$rec->transactionId)}}">Proceed</a>
                    </div>

              


                    </div>

                  </div>
                </div>
                

    </div>




 






  
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
        



  

@endsection