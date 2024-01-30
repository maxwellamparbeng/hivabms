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
   
    
    @if(auth()->user()->can('pos.updateproductdetailsquantity') )
   
    <a href="" data-bs-toggle="modal" data-bs-target="#edit{{$rec->id}}" class="btn btn-info">Edit </a>
   
    @endif


   @if(auth()->user()->can('pos.deletetransactionitem') )
   
   <a href="{{ route('pos.deletetransactionitem',$rec->id)}}" class="btn btn-primary">Delete</a>
   @endif
    
           
  
  </td>
           
  
  
             </tr>




<!-- Basic Modal -->

                
</button>
              <div class="modal fade" id="edit{{$rec->id}}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Update Quantity</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                 

                        <!-- Floating Labels Form -->
              <form name="" action="/updateproductdetailsquantity" method="POST" class="row g-3">
               
               @csrf
             <input type="hidden" id="_token" value="{{ csrf_token() }}">
             <input type="hidden" name="id" value="{{$rec->id }}"> 
             <input type="hidden" name="productId" value="{{$rec->productId}}"> 
             <input type="hidden" name="previousQuantity" value="{{ $rec->detailsQuantity }}"> 
                 <div class="col-md-4">
                   <div class="form-floating mb-3">
                   <input name="newQuantity" type="text" value="{{ $rec->detailsQuantity }}" class="form-control" id="floatingCity" placeholder="City">
                   </div>
                 </div>
                 <div class="col-md-2">
                   <div class="form-floating">
                   <button type="submit" class="btn btn-primary">Update</button>
                   </div>
                 </div>
                 
               </form><!-- End floating Labels Form -->


                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Update</button>
                    </div>
                  </div>
                </div>
              </div><!-- End Basic Modal-->











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