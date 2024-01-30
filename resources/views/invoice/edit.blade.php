@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Company details</h2>
        

        <div class="container mt-4">



      

            <form id="paymentForm" method="POST" action=" {{ route('product.updateproduct', $user->productId) }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
               

                  <input value="{{ $user->productId }}" 
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
                    <label for="title" class="form-label">Product name</label>
                    <input value="{{ $user->name}}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="" required>

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                     <input value="{{$user->pic}}" 
                        type="hidden" 
                        class="form-control" 
                        name="confirmPic" id="email"
                        placeholder="" required>

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
                        placeholder="" required>{{$user->description}}</textarea>

                    @if ($errors->has('Description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div>



                
                <label for="description" class="form-label">Status</label>

                
                   <select class="form-control" name="Status" required>
                
                        <option value="{{ $user->Status}}">Selected</option>
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>

                   </select>


                   <br>


            
                   <label for="description" class="form-label">category</label>

                
             <select class="form-control" name="category" required>

               <option value="{{ $user->categoryId }}">Selected</option>
                   
             @foreach($countries as $country)
             <option value="{{ $country->categoryId }}" >{{ $country->catName }}</option>
            
               
               @endforeach
                   </select>


                 <br>


                <div class="mb-3">
                    <label for="title" class="form-label">Price</label>
                    <input value="{{ $user->price }}" 
                        type="text" 
                        class="form-control" 
                        name="price" 
                        placeholder="" required>

                    @if ($errors->has('price'))
                        <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                    @endif
                </div>


                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('product.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection