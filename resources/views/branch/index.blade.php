@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('branch.add') )
   
    <a href="{{ route('branch.add') }}" class="btn btn-info">Add new branch</a>  
                         @endif



<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Branches</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Company Name</th>
                     <th scope="col">Branch Name</th>
                     <th scope="col">Phone</th>
                     <th scope="col">Location</th>
                     
                     
                     <th scope="col">Edit</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>

                <td>{{$loop->iteration}}</td>
                     <td>{{ $rec->companyName }}</td>
                    <td>{{ $rec->branchName }}</td>
                    <td>{{ $rec->branchPhone }}</td>
                    <td>{{ $rec->location }}</td>

                    @if(auth()->user()->can('branch.edit') )
   
                    <td><a href="{{ route('branch.edit', $rec->branchId) }}" class="btn btn-info">Edit </a></td>
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













