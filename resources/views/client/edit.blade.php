@extends('layouts.app-master')
@section('content')

    <div class="bg-light p-4 rounded card">
        <h2>Edit Client details</h2>
        

        <div class="container mt-4">

            <form id="paymentForm" method="POST" action=" {{ route('client.updateclient', $user->clientId) }}" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
               

                <input value="{{ $user->clientId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="email" id="email"
                        placeholder="" required>



                   <div class="mb-3">
                    <label for="title" class="form-label">Full name</label>
                    <input value="{{ $user->fullname }}" 
                        type="text" 
                        class="form-control" 
                        name="fullname" 
                        placeholder="" required>

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('companyName') }}</span>
                    @endif
                </div>

                   <br>
                <div class="mb-3">
                    <label for="title" class="form-label">Email</label>
                    <input value="{{ $user->emailAddress }}" 
                        type="text" 
                        class="form-control" 
                        name="email" 
                        placeholder="" >

                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Phone Number</label>
                    <input value="{{ $user->phoneNumber }}" 
                        type="text" 
                        class="form-control" 
                        name="phoneNumber" 
                        placeholder="" required>

                    @if ($errors->has('phoneNumber'))
                        <span class="text-danger text-left">{{ $errors->first('phoneNumber') }}</span>
                    @endif
                </div>



                <label for="description" class="form-label">Gender</label>

                
                   <select class="form-control" name="gender">
                
                        <option value="{{$user->gender}}">Selected</option>
                        <option value="male">male</option>
                        <option value="female">female</option>

                   </select>


                   <br>

                   <label for="description" class="form-label">Contact Group</label>      
                   <select class="form-control" name="contactgroupId" required>

       <option value="{{ $user->contactgroupId }}">Selected</option> 
       @foreach ($groups as $rec) 

<option value="{{ $rec->contactGroupId }}"> {{ $rec->name }}

</option>
@endforeach 



</select>



                <div class="mb-3">
                    <label for="title" class="form-label">Date of Birth</label>
                    <input value="{{ $user->dob }}" 
                        type="text" 
                        class="form-control" 
                        name="dob" 
                        placeholder="" required>
                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('lastName') }}</span>
                    @endif
                </div>



              



                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('client.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection