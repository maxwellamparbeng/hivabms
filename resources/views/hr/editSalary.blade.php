@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Salary details</h2>
        

        <div class="container mt-4">



      

            <form id="paymentForm" method="POST" action=" {{ route('hr.updateSalary', $user->salaryId) }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
               

                  <input value="{{ $user->salaryId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="deptId" id="email"
                        placeholder="" required>

                        <input value="{{$user->companyId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="companyId" id="email"
                        placeholder="" required>

                        <div class="mb-3">
                    <label for="title" class="form-label">Salary</label>
                    <input value="{{$user->salaryName }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="" >

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>

         
                   

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('hr.allSalary') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection