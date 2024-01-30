@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('account.add') )
   
  <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createpayrolls">Add new account</button>
  
       @endif



<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Account</h5>
              
             


              <div class="modal fade" id="createpayrolls" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Account </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


          <form id="paymentForm" method="POST" action=" {{ route('account.store') }}" enctype="multipart/form-data" >
           
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



              <div class="mb-3">
               <label for="title" class="form-label">Description</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="description" 
                   placeholder="" >

               @if ($errors->has('description'))
                   <span class="text-danger text-left">{{ $errors->first('description') }}</span>
               @endif
           </div>



           </div>

           <br>
           <button type="submit"  class="btn btn-info">Save</button>

         
       </form>
                    </div>

                    </div>

                  </div>







              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Name</th>

                     
                     <th scope="col">Description</th>


                     <th scope="col">Edit</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->description }}</td>     

                    @if(auth()->user()->can('account.edit') )
                   <td>
                    <a href="{{ route('account.edit',$rec->accountId) }}" class="btn btn-info">Edit </a>
                    <a href="{{ route('account.TransactionsByAccount', $rec->accountId) }}" class="btn btn-info">View Transactions </a>
                   
                  </td>
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













