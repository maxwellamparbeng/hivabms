@extends('layouts.app-public')

@section('content')
    <div class="bg-light p-4 rounded">
       
        <div class="lead">
           
        </div>

        <div class="card container mt-4">

             Please fill in the following information
             <br>
             <br>


@if ($message = Session::get('success'))


<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
{{ $message }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>


@endif



@if ($message = Session::get('error'))


<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
{{ $message }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

@endif




            <form method="POST" action="{{ route('client.storeExternalClient') }}">
                @csrf


                <input  
                        type="hidden" 
                        class="form-control" 
                        name="companyId" value="{{ request()->route('id') }}" 
                        placeholder="" required>

                <div class="mb-3">
                    <label for="title" class="form-label">Full name</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="fullname" 
                        placeholder="" required >

                    @if ($errors->has('fullname'))
                        <span class="text-danger text-left">{{ $errors->first('fullname') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Email</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="emailAddress" 
                        placeholder=""  >

                    @if ($errors->has('emailAddress'))
                        <span class="text-danger text-left">{{ $errors->first('emailAddress') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Phone Number</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="phoneNumber" 
                        placeholder="" required >

                    @if ($errors->has('phoneNumber'))
                        <span class="text-danger text-left">{{ $errors->first('phoneNumber') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Date of Birth</label>
                    <input value="" 
                        type="date" 
                        class="form-control" 
                        name="dob" 
                        placeholder="" >
                    @if ($errors->has('dob'))
                        <span class="text-danger text-left">{{ $errors->first('dob') }}</span>
                    @endif
                </div>



                <label for="description" class="form-label">Gender</label>

                
                   <select class="form-control" name="gender" required>
                
                   <option value="">Choose</option> 
                        <option value="male">male</option>
                        <option value="female">female</option>



                   </select>

         @if ($errors->has('gender'))
                        <span class="text-danger text-left">{{ $errors->first('gender') }}</span>
                    @endif

                   <br>

      
         

                <button type="submit" class="btn btn-primary">Submit</button>
                
            </form>
        </div>

    </div>
@endsection