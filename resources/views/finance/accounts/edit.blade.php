@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Account details</h2>
        
        <div class="container mt-4">

        <form id="paymentForm" method="POST" action="{{ route('account.update',$user->accountId) }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
       <input type="hidden" name="accountId" value="{{ $user->accountId }}">
     
          
           <div class="mb-3">
               <label for="title" class="form-label">Name</label>
               <input value="{{ $user->name }}" 
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
               <input value="{{ $user->description }}" 
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
           <button type="submit"  class="btn btn-primary">Update</button>

         
       </form>

        </div>

    </div>



@endsection