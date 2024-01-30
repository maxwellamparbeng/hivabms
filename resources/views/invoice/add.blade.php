@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add product</h2>
        <div class="container mt-4">
            <form id="paymentForm" method="POST" action="/store" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
                   <div class="mb-3">
                    <label for="title" class="form-label">Product name</label>
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
                    <label for="description" class="form-label">Product description</label>
                    <textarea class="form-control" 
                        name="description" 
                        placeholder="" ></textarea>

                    @if ($errors->has('Description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div>



                
                <label for="description" class="form-label">Status</label>

                
                   <select class="form-control" name="Status" >
            
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>

                   </select>


                   <br>


            
                   <label for="description" class="form-label">category</label>

                
             <select class="form-control" name="category" >

              
           
            
            
            @foreach($countries as $country)
        <option value="{{ $country->categoryId }}" >{{ $country->catName }}</option>
      @endforeach

             
             </select>

                   
                 <br>


                <div class="mb-3">
                    <label for="title" class="form-label">Price</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="price" 
                        placeholder="" >

                    @if ($errors->has('price'))
                        <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                    @endif
                </div>


                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Add</button>

                <a href="{{ route('product.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection