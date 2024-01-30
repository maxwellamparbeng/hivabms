@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        <div class="lead">
            Add new client
        </div>

        <div class="card container mt-4">

            <form method="POST" action="{{ route('client.store') }}">
                @csrf
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
                        type="text" 
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



                   <label for="description" class="form-label">Contact Group</label>      
                   <select class="form-control" name="contactgroupId" required>

       <option value="">Choose</option> 
       @foreach ($groups as $rec) 

<option value="{{ $rec->contactGroupId }}"> {{ $rec->name }}

</option>
@endforeach 



</select>

@if ($errors->has('contactgroupId'))
     <span class="text-danger text-left">{{ $errors->first('contactgroupId') }}</span>
 @endif

<br>

      
                   
         

                <button type="submit" class="btn btn-primary">Add client</button>
                <a href="{{ route('client.show') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection