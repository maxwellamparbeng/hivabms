@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Allowance details</h2>
        

        <div class="container mt-4">



      

            <form id="paymentForm" method="POST" action=" {{ route('payroll.updateAllowance', $user->allowanceId) }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
    
            <div class="mb-3">
                    <label for="title" class="form-label">Allowance Name</label>
                    <input value="{{ $user->allowance }}" 
                        type="text" 
                        class="form-control" 
                        name="allowance" 
                        placeholder="" >

                    @if ($errors->has('allowance'))
                        <span class="text-danger text-left">{{ $errors->first('allowance') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Allowance Description</label>
                    <input value="{{ $user->description }}" 
                        type="text" 
                        class="form-control" 
                        name="description" 
                        placeholder="" >

                    @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div> 

          
                

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('payroll.allAllowance') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection