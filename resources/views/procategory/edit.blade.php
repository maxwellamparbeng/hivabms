@extends('layouts.app-public')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Company details</h2>
        

        <div class="container mt-4">



      

            <form id="paymentForm" method="POST" action=" {{ route('productcategory.updateproductcategory', $user->categoryId) }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
               

                  <input value="{{ $user->categoryId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="email" id="email"
                        placeholder="" required>

                        <input value="{{$user->companyId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="email" id="email"
                        placeholder="" required>

                        <div class="mb-3">
                    <label for="title" class="form-label">Category Name</label>
                    <input value="{{$user->catName }}" 
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
                        placeholder="" >{{$user->details }}</textarea>

                    @if ($errors->has('Description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div>  
                   

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('product.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection