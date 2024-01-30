@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Transaction Log</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  
                    <th scope="col">Product Id</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Before transaction</th>
                    <th scope="col">After transaction</th>
                    <th scope="col">User</th>
                    <th scope="col">Date Created</th>
                   
                    
                   
                  </tr>
                </thead>
                <tbody>

               
               
                @foreach ($details as $rec)
<tr>

                
    <th scope="row">{{ $rec->productId }}</th>
    <td>{{ $rec->name }}</td>
    <td>{{ $rec->inventoryQuantityBefore }}</td>
    <td>{{ $rec->inventoryQuantityAfter }}</td>
    <td>{{ $rec->username }}</td>
    <td>{{ $rec->created_at }}</td>
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