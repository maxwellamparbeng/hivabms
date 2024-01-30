@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        
    
        <div class="container mt-4 card">

        <h2>Edit Employee details</h2>
        <br>
            <form id="paymentForm" method="POST" action=" {{ route('hr.updateEmployee', $user->employeeId) }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
    
                        <div class="mb-3">
                    <label for="title" class="form-label">Employee Name</label>
                    <input value="{{ $user->employeeName }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="" >

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Email</label>
                    <input value="{{ $user->email }}" 
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
                        placeholder="" >

                    @if ($errors->has('phoneNumber'))
                        <span class="text-danger text-left">{{ $errors->first('phoneNumber') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Date Of Birth</label>
                    <input value="{{ $user->dateOfBirth }}" 
                        type="text" 
                        class="form-control" 
                        name="dateOfBirth" 
                        placeholder="" >

                    @if ($errors->has('dateOfBirth'))
                        <span class="text-danger text-left">{{ $errors->first('dateOfBirth') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Employment code</label>
                    <input value="{{ $user->empCode}}" 
                        type="text" 
                        class="form-control" 
                        name="empCode" 
                        placeholder="" >

                    @if ($errors->has('empCode'))
                        <span class="text-danger text-left">{{ $errors->first('empCode') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Hire Date</label>
                    <input value="{{ $user->hireDate }}" 
                        type="text" 
                        class="form-control" 
                        name="hireDate" 
                        placeholder="" >

                    @if ($errors->has('hireDate'))
                        <span class="text-danger text-left">{{ $errors->first('hireDate') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Level of Education</label>

            <select class="form-control" name="eduId" >
           
            <option value="{{ $user->eduId }}" >{{ $user->eduId }}</option>
            

            @foreach($alledu as $edu)
            <option value="{{ $edu->eduName }}" >{{ $edu->eduName }}</option>
             @endforeach
             </select>
                 <br>



                    @if ($errors->has('eduId'))
                        <span class="text-danger text-left">{{ $errors->first('eduId') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Department</label>
                    
                        <select class="form-control" name="deptId" >

                               
        
        
          @foreach($employeeDetails as $depart)
            <option value="{{ $depart->deptId }}" >{{ $depart->deptName }}</option>
             @endforeach
             
          



            @foreach($dept as $depart)
            <option value="{{ $depart->deptId }}" >{{ $depart->deptName }}</option>
             @endforeach
             </select>
                 

                    @if ($errors->has('deptId'))
                        <span class="text-danger text-left">{{ $errors->first('deptId') }}</span>
                    @endif
                </div>

                <br>


                <div class="mb-3">
                    <label for="title" class="form-label">Position</label>
                        <select class="form-control" name="jobId" >

                        @foreach($employeeDetails as $depart)
            <option value="{{ $depart->jobId }}" >{{ $depart->jobName }}</option>
             @endforeach


          
            
            @foreach($allpositions as $pos)
            <option value="{{ $pos->jobId }}" >{{ $pos->jobName }}</option>
             @endforeach
             </select>  
                    @if ($errors->has('jobId'))
                        <span class="text-danger text-left">{{ $errors->first('jobId') }}</span>
                    @endif
                </div>


              


                <div class="mb-3">
                    <label for="title" class="form-label">Salary</label>
                        <select class="form-control" name="salaryId" >


                        @foreach($employeeDetails as $depart)
            <option value="{{ $depart->salaryId }}" >{{ $depart->salaryName}}</option>
             @endforeach
          
             @foreach($salary as $sal)
            <option value="{{ $sal->salaryId }}" >{{ $sal->salaryName }}</option>
             @endforeach
             </select>  

                    @if ($errors->has('jobId'))
                        <span class="text-danger text-left">{{ $errors->first('salaryId') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Address</label>
                    <input value="{{ $user->address }}" 
                        type="text" 
                        class="form-control" 
                        name="address" 
                        placeholder="" >
                    @if ($errors->has('jobId'))
                        <span class="text-danger text-left">{{ $errors->first('address') }}</span>
                    @endif
                </div>


                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <br><br>
          
                </div>

                
            </form>
        </div>

    </div>



@endsection