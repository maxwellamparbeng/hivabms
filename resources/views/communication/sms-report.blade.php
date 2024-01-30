@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        
 
<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Sms report</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                    <th scope="col">Campaign Id</th>
                    <th scope="col">Category</th>
                    <th scope="col">Campaign Type</th>
                    <th scope="col">Number of receipents</th>
                    <th scope="col">Message</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Sent</th>
  
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)

                <tr>
              
               
               
              

                    <th scope="row">{{ $rec->campaignId }}</th>
                    <td>{{ $rec->category }}</td>
                    <td>{{ $rec->campaignType }}</td>
                    <td>{{ $rec->totalSent }}</td>
                    <td>{{ $rec->message }}</td>
                    <td>{{ $rec->status }}</td>
                    <td>{{ $rec->dateCreated }}</td>
                   
                
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