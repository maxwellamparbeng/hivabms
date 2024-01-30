@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
   
    @if(auth()->user()->can('client.index') )
    <a href="{{ route('client.index') }}" class="btn btn-info">Add new client</a>
                    @endif


                    @if(auth()->user()->can('export.clients') )
    <a href="{{ route('export.clients') }}" class="btn btn-info">Export Clients info</a> 
       @endif

       
@if(auth()->user()->can('contactgroup.store') )
<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createpayrolls">Add Contact Group</button>
@endif
<br>
<br>

<section class="section">
      <div class="row">


      <div class="col-lg-4">

          <div class="card">
            <div class="card-body">
            <h5 class="card-title">Contact Group</h5>

            <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  <th scope="col">#</th>
                    <th scope="col">Group Name</th>
                    <th scope="col">Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($groups as $rec)

                <tr>

                    <td>{{$loop->iteration}}</td>
                    <td>{{ $rec->name }}</td>
                 
                    
                    @if(auth()->user()->can('contactgroup.update') )
  
   
       <td><a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal{{ $rec->contactGroupId }}">Edit</a>
  
       @if(auth()->user()->can('contactgroup.view') )
  
   
       </br></br><a href="{{ route('contactgroup.view',$rec->contactGroupId) }}" class="btn btn-info">View</a></td>


     @endif
  
          @endif


                    
                   
                  
             </tr>





             <div class="modal fade" id="basicModal{{ $rec->contactGroupId }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Update {{ $rec->name }} ?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    

                    <form id="paymentForm" method="POST" action=" {{ route('contactgroup.update') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
         
     
          
           <div class="mb-3">
               <label for="title" class="form-label">Name</label>
               <input 
                   type="text" 
                   class="form-control" 
                   name="name"
                   value="{{ $rec->name }}" 
                   placeholder=""
                    >

               @if ($errors->has('name'))
                   <span class="text-danger text-left">{{ $errors->first('name') }}</span>
               @endif
           </div>

               <input 
                   type="hidden" 
                   class="form-control" 
                   name="contactgroupId"
                   value="{{$rec->contactGroupId}}" 
                   placeholder="">
                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     
                      <button type="submit"  class="btn btn-info">Update</button>
                    </div>

                    </form>


                    </div>

                  </div>
                </div>
                

    </div>






             @endforeach

                  
                   
                  
                
                 
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>

            </div>
            </div>
           </div>



        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Customers</h5>
              
             
             
              <div class="modal fade" id="createpayrolls" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Add Contact Group</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


          <form id="paymentForm" method="POST" action=" {{ route('contactgroup.store') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
         
     
          
           <div class="mb-3">
               <label for="title" class="form-label">Name</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="name" 
                   placeholder="" >

               @if ($errors->has('name'))
                   <span class="text-danger text-left">{{ $errors->first('name') }}</span>
               @endif
           </div>
           </div>

           <br>
           <button type="submit"  class="btn btn-info">Save</button>

         
       </form>
                    </div>

                    </div>

                  </div>
             
             
             
             
             
             
             
             
             
              @include('sweet::alert')
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Client Name</th>
                    <th scope="col">Contact Group</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)

                <tr>

                   
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $rec->fullname }}</td>
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->emailAddress }}</td>
                    <td>{{ $rec->phoneNumber }}</td>
                    
                    <td>{{ $rec->gender}}</td>
                    <td>{{ $rec->dob}}</td>
                    
                    
    @if(auth()->user()->can('client.editclient') )
   
    <td><a href="{{ route('client.editclient', $rec->clientId) }}" class="btn btn-info">Edit </a></td>
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