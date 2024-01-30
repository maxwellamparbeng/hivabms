@extends('layouts.app-public')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add product category</h2>
        

        <div class="container mt-4">



      

            <form id="paymentForm" method="POST" action=" {{ route('productcategory.store') }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
                   <div class="mb-3">
                    <label for="title" class="form-label">Category Name</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="" >

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="col-md-6">
                    <input type="file" name="image" class="form-control">
                
                    @if ($errors->has('image'))
                        <span class="text-danger text-left">{{ $errors->first('image') }}</span>
                    @endif

                </div>


                <div class="mb-3">
                    <label for="description" class="form-label">Category description</label>
                    <textarea class="form-control" 
                        name="description" 
                        placeholder="" ></textarea>

                    @if ($errors->has('Description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div>



                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Add</button>

                <a href="{{ route('productcategory.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection