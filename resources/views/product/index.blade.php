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
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Products</h5>
              @if(auth()->user()->can('export.Product') )
    <a href="{{ route('export.Product') }}" class="btn btn-info">Export Products</a> 
       @endif
              <?php 
                  
                  $pricing = getusercompanyproductpricinginfo();
                  
           
               ?>

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable " id="datatable">
                <thead>
                  <tr>

                  @if($pricing=="Multiple")

                  <th scope="col">Image</th>
                   <th scope="col">Product Name</th>
                   <th scope="col">Category</th>
                   <th scope="col">Description</th>
                   <th scope="col">Status</th>
                   <th scope="col">Unit Price</th>
                   <th scope="col">Cost Price</th>
                   <th scope="col">WholeSale Price</th>
                   <th scope="col">Bulk WholeSale Price</th>
                   <th scope="col">Promo Bulk WholeSale Price</th>
                   <th scope="col">Retail Price</th>
                   <th scope="col">Promo Retail Price</th>
                   <th scope="col">Action</th>

                  @endif


                  @if($pricing=="Single")

<th scope="col">Image</th>
 <th scope="col">Product Name</th>
 <th scope="col">Category</th>
 <th scope="col">Description</th>
 <th scope="col">Status</th>
 <th scope="col">Unit Price</th>
 <th scope="col">Action</th>

@endif

                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)

                <tr>


                @if($pricing=="Multiple")

                @if (empty($rec->pic) )
                <th scope="row"><img height="50px" width="100px" src="/storage/dummy.jpg" alt="" title=""></th>
                 @else
                 <th scope="row"><img height="50px" width="100px" src="{{Storage::url($rec->pic)}}" alt="" title=""></th>
                @endif
                
                
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->catName }}</td>
                    <td>{{ $rec->description }}</td>
                    <td>{{ $rec->Status }}</td>
                    <td>{{ $rec->price }}</td>
                    <td>{{ $rec->cprice }}</td>
                    <td>{{ $rec->whprice }}</td>
                    <td>{{ $rec->bwhprice }}</td>
                    <td>{{ $rec->pbwhprice }}</td>
                    <td>{{ $rec->rprice }}</td>
                    <td>{{ $rec->prprice }}</td>
                    <td>
                      
                    @if(auth()->user()->can('product.edit') )
    
    <a href="{{ route('product.edit', $rec->productId) }}" class="btn btn-info">Edit </a>
       @endif


       @if(auth()->user()->can('product.delete') )
    
    <a href="{{ route('product.delete', $rec->productId) }}" class="btn btn-info">Delete </a>
       @endif
                    
                  
                  
                  </td>

                @endif


                @if($pricing=="Single")

                @if (empty($rec->pic) )
                <th scope="row"><img height="50px" width="100px" src="/storage/dummy.jpg" alt="" title=""></th>
                 @else
                 <th scope="row"><img height="50px" width="100px" src="{{Storage::url($rec->pic)}}" alt="" title=""></th>
                @endif
                
                
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->catName }}</td>
                    <td>{{ $rec->description }}</td>
                    <td>{{ $rec->Status }}</td>
                    <td>{{ $rec->price }}</td>
                   
                    <td>
                      
                    @if(auth()->user()->can('product.edit') )
    
    <a href="{{ route('product.edit', $rec->productId) }}" class="btn btn-info">Edit </a>
       @endif
                    
       @if(auth()->user()->can('product.delete') )
    
    <a href="{{ route('product.delete', $rec->productId) }}" class="btn btn-info">Delete </a>
       @endif 
                  
                  </td>

                @endif
                
               
              
                      
             </tr>
             @endforeach

                  
                   
                  
                
                 
                </tbody>
              </table>


              {!! $records->links() !!}  

              <!-- End Table with stripped rows -->

            </div>
          </div>
          </div>
        </div>
      </div>
    </section>





   
    </div>

@endsection













