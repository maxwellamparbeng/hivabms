@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        
    @if(auth()->user()->can('product.add') )
    <a href="{{ route('product.add') }}" class="btn btn-info">Add new product</a> 
  
       @endif


     
<br>
<br> 

<section class="section">


<div class="row">
      
      <div class="col-md-12 ">



      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Update Inventory</h5>

          <!-- Floating Labels Form -->
          <form name="" action="{{ route('pos.updateinventory') }}" method="POST" class="row g-3">
           
          @csrf
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
          
                 <div class="col-md-6">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="product" class="form-select" id="js-example-basic-single" aria-label="State">
                   @foreach($products as $pro)
                  <option value="{{$pro->productId }}" >{{ $pro->name }}</option>
                  @endforeach 
                   </select>
                   
                 </div>

                  </div>
                </div>


            <div class="col-md-4">
              <div class="form-floating mb-3">
             
              <div class="row mb-3">
              <label for="inputDate" class="col-sm-2 col-form-label">Quantity</label>
              <div class="col-sm-10">
                <input type="text" name="quantity" class="form-control">
                
                <input type="hidden" name="branchId" value="{{ $branch }}" class="form-control">

              </div>
            </div>

              
              </div>
            </div>


            <div class="col-md-2">
              <div class="form-floating">
              

              <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
            
          </form><!-- End floating Labels Form -->

        </div>
      </div>



      </div>
      </div>













      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Inventory</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     <th scope="col">Image</th>
                    <th scope="col">Product Id</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                   
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($products as $rec)

                <tr>
                
               
                @if (empty($rec->pic) )
                <th scope="row"><img height="50px" width="100px" src="/storage/dummy.jpg" alt="" title=""></th>
                 @else
                 <th scope="row"><img height="50px" width="100px" src="{{Storage::url($rec->pic)}}" alt="" title=""></th>
                @endif
                
                
                    <th scope="row">{{ $rec->productId }}</th>
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->invQuantity }}</td>
                    <td>
                   
                    
         
         


    <div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu">
    
  @if(auth()->user()->can('pos.transferstock') )

  <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#transferstock{{ $rec->productId }}">Transfer Stock</a>
 
  @endif
 

       @if(auth()->user()->can('pos.reducestock') )

    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reducestock{{ $rec->productId }}">Reduce Stock</a>
    @endif
    
  
    @if(auth()->user()->can('pos.transferstocklog') )
    
    <a class="dropdown-item" href="{{ route('pos.transferstocklog',$rec->productId)}}">View Log</a>
  
    @endif

                  </td>





          <div class="modal fade" id="transferstock{{ $rec->productId }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Transfer Stock</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    <form id="paymentForm" method="POST" action="/transferstock"  >
       
                    @csrf
                     <input type="hidden" id="_token" value="{{ csrf_token() }}">
                     <input type="hidden" name="frombranchId" value="{{ $rec->branchId }}">
                     <input type="hidden" name="productId" value="{{ $rec->productId }}">
                    <div class="mb-3">
                    <label for="title" class="form-label">Product name - {{ $rec->name }}</label></br></br>
                    <label for="title" class="form-label">Quantity</label>
                     <input value="" 
                     type="text" 
                     class="form-control" 
                     name="quantity" 
                     placeholder="" >

                    @if ($errors->has('title'))
                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif




                   </div>



                    <div class="mb-3">
                    <label for="title" class="form-label">Branch</label>

                    <select class="form-control" name="tobranchId">
                      @foreach($branches as $country)
                     <option value="{{ $country->branchId }}" >{{ $country->branchName }}</option>
                      @endforeach
                    </select>
                  
                  
                  
                  </div>


                  <button type="submit" class="btn btn-danger" >Proceed</button>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      
                     </div>

                     </form>
                    </div>

                  </div>
                </div>
             </div>






             <div class="modal fade" id="reducestock{{ $rec->productId }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Reduce Stock</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   
                    <div class="modal-body">

<form id="paymentForm" method="POST" action="{{ route('pos.reducestock') }}" enctype="multipart/form-data" >

@csrf
 <input type="hidden" id="_token" value="{{ csrf_token() }}">
 <input type="hidden" name="frombranchId" value="{{ $rec->branchId }}">
 <input type="hidden" name="productId" value="{{ $rec->productId }}">
<div class="mb-3">
<label for="title" class="form-label">Product name - {{ $rec->name }}</label></br></br>
<label for="title" class="form-label">Quantity</label>
 <input value="" 
 type="text" 
 class="form-control" 
 name="quantity" 
 placeholder="" >

@if ($errors->has('title'))
<span class="text-danger text-left">{{ $errors->first('name') }}</span>
@endif




</div>


<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-danger" >Proceed</button>

 </div>

 </form>
</div>

                  </div>
                </div>
             </div>




                      
             </tr>
             @endforeach

                  
             
                  
                
                 
                </tbody>
              </table>


              {!! $products->links() !!}  
              <!-- End Table with stripped rows -->

            </div>
          </div>
          </div>
        </div>
      </div>
    </section>





   
    </div>

@endsection













