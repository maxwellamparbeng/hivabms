@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add Branch </h2>
        

        <div class="container mt-4">



      

            <form id="paymentForm" method="POST" action=" {{ route('branch.store') }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
                   <div class="mb-3">
                    <label for="title" class="form-label">Branch Name</label>
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
                    <label for="title" class="form-label">Branch Phone Number</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="phone" 
                        placeholder="" >

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('phone') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Location</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="location" 
                        placeholder="" >

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('location') }}</span>
                    @endif
                </div>

                


                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Add</button>

                <a href="{{ route('branch.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection