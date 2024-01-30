@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('productcategory.add') )
   
    <a href="{{ route('productcategory.add') }}" class="btn btn-info">Add new category</a>  
                         @endif



<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Product Category</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     <th scope="col">Image</th>
                     <th scope="col">Category Name</th>
                     <th scope="col">Description</th>
                     <th scope="col">Edit</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>


                @if (empty($rec->pic) )
                <th scope="row"><img height="50px" width="100px" src="storage/dummy.jpg" alt="" title=""></th>
                 @else
                 <th scope="row"><img height="50px" width="100px" src="{{Storage::url($rec->catPic)}}" alt="" title=""></th>
                @endif


               
                    <td>{{ $rec->catName }}</td>
                    <td>{{ $rec->details }}</td>

                    @if(auth()->user()->can('productcategory.edit') )
   
                    <td><a href="{{ route('productcategory.edit', $rec->categoryId) }}" class="btn btn-info">Edit </a></td>
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













