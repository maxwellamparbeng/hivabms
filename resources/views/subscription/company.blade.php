@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Subscriptions</h5>
              
              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                    <th scope="col">Logo</th>
                  
                    <th scope="col">Company Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Subscription</th>
                    <th scope="col">Amount to be paid</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)

                <tr>
              
               
               
              
                @if (empty($rec->logo) )
                <th scope="row"><img height="50px" width="100px" src="/storage/dummy.jpg" alt="" title=""></th>
                 @else
                 <th scope="row"><img height="50px" width="100px" src="{{Storage::url($rec->logo)}}" alt="" title=""></th>
                @endif
                   
                    <td>{{ $rec->companyName }}</td>
                    <td>{{ $rec->email }}</td>
                    <td>{{ $rec->phoneNumber }}</td>
                    <td>{{ $rec->subscriptionName }}</td>
                    <td>{{ $rec->amount }}</td>
                    
                    
                    @if($rec->paymentStatus ==0)         
                    <td>Unpaid</td>
                    @else
                  <td>Paid</td>        
               
                    @endif
                  

                    @if(auth()->user()->can('subscription.pay') )
                    
                    @if($rec->paymentStatus ==0)         
                    <td><a href="{{ route('subscription.pay', $rec->subscriptionId) }}" class="btn btn-info">Pay </a></td>
                    @else
                    
                    <td>Paid</td>  
               
                    @endif
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