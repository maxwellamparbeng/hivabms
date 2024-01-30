@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">



    <div class="row">
      
          <div class="col-md-12 ">



          </div>
          </div>





      <div class="row">
        <div class="col-lg-12">


        
        
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Invoices</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  
                    <th scope="col">Invoice Id</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Phone number</th>
                    
                    <th scope="col">Total Amount</th>
                    <th scope="col">Payment method</th>
                    <th scope="col">Address</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Invoice Type</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

               
               
                @foreach ($details as $rec)
<tr>
    <th scope="row">{{ $rec->invoiceId }}</th>
    <td>{{ $rec->customerName }}</td>
    <td>{{ $rec->email }}</td>
    <td>{{ $rec->phoneNumber }}</td>
    <td>{{ $rec->amount }}</td>
    <td>{{ $rec->paymentType}}</td>
    <td>{{ $rec->address}}</td>
    <td>{{ $rec->paymentStatus}}</td>
    <td>{{ $rec->invoiceType}}</td>
    <td>{{ $rec->created_at}}</td>


    

    
  <td>
    
  
  <div class="btn-group">
<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  Action
</button>
<div class="dropdown-menu">
  
@if(auth()->user()->can('invoice.viewtransactiondetails') )
  
<a class="dropdown-item" href="{{route('invoice.viewtransactiondetails',$rec->invoiceId)}}">Info</a>
     @endif

 
     @if(auth()->user()->can('invoice.viewinvoice') )
 
  <a class="dropdown-item" href="{{ route('invoice.viewinvoice',$rec->invoiceId)}}">Invoice</a>
  @endif
  
  @if(auth()->user()->can('invoice.cancel') )
  
  @if($rec->status=="COMPLETED")
 
  <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#basicModal{{ $rec->invoiceId }}">Cancel Invoice</a>
 @endif
 @endif


 @if(auth()->user()->can('invoice.editinvoice') )
 <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reset{{ $rec->invoiceId }}">Edit Invoice</a>
 @endif
 


 

</div>
  

</td>



  
   









  <div class="modal fade" id="reset{{ $rec->invoiceId }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Invoice Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">



                    <form name="" action="{{ route('invoice.editinvoice') }}" method="POST" class="row g-3">
              @csrf
             <input type="hidden" id="_token" value="{{ csrf_token() }}">  
             <input type="hidden" name="invoiceId" value="{{ $rec->invoiceId}}"  class="form-control" id="floatingEmail" readonly placeholder="Your Email">
               <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="invoiceType" class="form-select" id="floatingSelect" aria-label="State">
                   
                   <option value="{{ $rec->invoiceType}}" >{{ $rec->invoiceType}}</option>
                  <option value="Proforma Invoice" >Proforma Invoice</option>
                   </select>
                   <label for="floatingSelect">Invoice Type</label>
                 </div>

                  </div>
                </div>

                <br>

              <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" name="name" value="{{ $rec->customerName }}" class="form-control" id="floatingName" placeholder="Your Name">
                    <label for="floatingName">Customer name</label>
                  </div>
                </div>
                <br>
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="email" name="email" value="{{ $rec->email }}" class="form-control" id="floatingEmail" placeholder="Your Email">
                    <label for="floatingEmail">Email</label>
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
                    <input type="phone" name="phone" value="{{ $rec->phoneNumber }}" class="form-control" id="floatingEmail" placeholder="Your Email">
                    <label for="floatingEmail">Phone</label>
                  </div>
                </div>


              <br>

                <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="paymentType" class="form-select" id="floatingSelect" aria-label="State">
                
                   <option value="{{ $rec->paymentType}}" >{{ $rec->paymentType}}</option>
                  <option value="cash" >Cash</option>
                  <option value="mobile money" >Mobile money</option>
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
                    <label for="floatingTextarea">Invoice note</label>
                  </div>
                </div>
                
                <br>
              
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Update Invoice</button>
                 
                </div>
              </form><!-- End floating Labels Form -->
                    
         


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
        


    </div>

@endsection