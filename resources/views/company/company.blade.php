@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
    @if(auth()->user()->can('company.addnewcompany') )
    <a href="{{ route('company.addnewcompany') }}" class="btn btn-info">Add new company</a>   
    @endif

   

<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              
              
              

              <?php
              
              $counter=count($records);

              if($counter==0 || $counter==1){

               echo '<h5 class="card-title">Company Info</h5>';
              }

              else{
                echo '<h5 class="card-title">All Companies</h5>';
              }
              
              ?>
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                    <th scope="col">Logo</th>
                    <th scope="col">Company Id</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Description</th>
                    <th scope="col">Sms Api Key</th>
                    <th scope="col">Sms Api Username</th>
                    <th scope="col">Status</th>
                    <th scope="col">Product Pricing</th>
                    <th scope="col">Subscription</th>
                    <th scope="col">Amount to be paid</th>
                    <th scope="col">Tin number</th>
                    <th scope="col">Edit</th>
                    
                   
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
                    <th scope="row">{{ $rec->companyId }}</th>
                    <td>{{ $rec->companyName }}</td>
                    <td>{{ $rec->email }}</td>
                    <td>{{ $rec->phoneNumber }}</td>
                    <td>{{ $rec->companyDescription }}</td>
                    <td>{{ $rec->smsApikey }}</td>
                    <td>{{ $rec->smsApiusername }}</td>
                    <td>{{ $rec->status }}</td>
                    <td>{{ $rec->ProductPricing }}</td>
                    <td>{{ $rec->subscriptionName }}</td>
                    <td>{{ $rec->amount }}</td>
                    <td>{{ $rec->tin }}</td>
                    
                    @if(auth()->user()->can('company.editcompany') )
                    <td><a href="{{ route('company.editcompany', $rec->companyId) }}" class="btn btn-info">Edit </a></td>
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