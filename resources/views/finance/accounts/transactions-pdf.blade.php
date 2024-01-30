@extends('layouts.app-public')

@section('content')
    <div class="bg-light p-4 rounded">
       
      
<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Account Transactions</h5>
              
              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Name</th>
                     <th scope="col">Amount</th>
                     <th scope="col">Description</th>
                     <th scope="col">Branch</th>
                     <th scope="col">Date</th>
                     
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($transactions as $rec)
                <tr>


               
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->amount }}</td>   
                    <td>{{ $rec->transDescription }}</td>  
                    <td>{{ $rec->branchName }}</td>
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













