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
                    
                    <th scope="col">Edit</th>
                    
                   
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
                      
                    @if(auth()->user()->can('product.edit') )
    
    <a href="{{ route('product.edit', $rec->productId) }}" class="btn btn-info">Edit </a>
       @endif
                    
                  
                  
                  </td>
                      
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













