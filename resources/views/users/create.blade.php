@extends('layouts.app-master')

@section('content')

<div class="card">
            <div class="card-body">

    <div class="bg-light p-4 rounded">
        <h1>Add new user</h1>
        <div class="lead">
            Add new user and assign role.
        </div>

        <div class="container mt-4">
            <form method="POST" action="">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{ old('email') }}"
                        type="email" 
                        class="form-control" 
                        name="email" 
                        placeholder="Email address" required>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input value="{{ old('username') }}"
                        type="text" 
                        class="form-control" 
                        name="username" 
                        placeholder="Username" required>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" 
                        name="role" required>
                        <option value="">Select role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                               >{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('role'))
                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                    @endif
                </div>



                <label for="email" class="form-label">Company</label>

                   <select class="form-control" name="companyId"> 
                    <option>Select Company</option> 
                    @foreach ($company as $key => $value) 

                  <option value="{{ $key }}"> {{ $value }}
                
                  </option>
                     @endforeach 
                    
                    </select>

                      <br>
                    <label for="email" class="form-label">User Type</label>

                   <select class="form-control" name="userType"> 
                  <option value="Admin">Administrator
                
                  </option>


                  <option value="subAdmin">Sub Administrator
                
                  </option>

                  <option value="none">None</option> 
                   
                    
                    </select>


                       <br>
                    <label for="email" class="form-label">Branch</label>

                   <select class="form-control" name="branchId" required> 
                    <option value="">Select Branch</option> 
                    <option value="none">None</option> 
                    @foreach ($branch as $key => $value) 

                  <option value="{{ $key }}"> {{ $value }}
                
                  </option>
                     @endforeach 
                    
                    </select>


                    



<br>
<br>
                <button type="submit" class="btn btn-primary">Save user</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
    </div>
    </div>

    
@endsection
