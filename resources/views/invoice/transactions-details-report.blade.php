@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Transactions</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  
                    <th scope="col">Image</th>
                    <th scope="col">Product Id</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Sales By</th>
                    <th scope="col">Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

               
               
                @foreach ($cartdata as $rec)
                <tr>
                @if (empty($rec->pic) )
                <th scope="row"><img height="50px" width="100px" src="/storage/dummy.jpg" alt="" title=""></th>
                 @else
                 <th scope="row"><img height="50px" width="100px" src="{{Storage::url($rec->pic)}}" alt="" title=""></th>
                @endif
                
                <th scope="row">{{ $rec->productId }}</th>
                <td>{{ $rec->name }}</td>
                <td>{{ $rec->detailsQuantity}}</td>
                <td>{{ $rec->price }}</td>
                <td>
                {{ $rec->username }}
  
                </td>
           
  
  
             </tr>




<!-- Basic Modal -->

                
</button>
          










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