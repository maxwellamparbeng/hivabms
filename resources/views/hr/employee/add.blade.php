@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add Employees</h2>
        

        <div class="container mt-4">

            <form id="paymentForm" method="POST" action=" {{ route('hr.storeEmployee') }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
                   <div class="mb-3">
                    <label for="title" class="form-label">Employee Name</label>
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
                    <label for="title" class="form-label">Email</label>
                    <input value="" 
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
                    <input value="" 
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
                    <input value="" 
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
                    <input value="" 
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
                    <input value="" 
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
            @foreach($salary as $sal)
            <option value="{{ $sal->salaryId }}" >{{ $sal->salaryName }}</option>
             @endforeach
             </select>  

                    @if ($errors->has('salaryId'))
                        <span class="text-danger text-left">{{ $errors->first('salaryId') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Address</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="address" 
                        placeholder="" >

                    @if ($errors->has('address'))
                        <span class="text-danger text-left">{{ $errors->first('address') }}</span>
                    @endif
                </div>

          
                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Add</button>

                <a href="{{ route('hr.alldepartments') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection