@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded card">
        <h2>Edit Product details</h2>
        

        <div class="container ">



      

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

                
                   <select class="form-control" name="Status" >
                
                        <option value="{{ $user->Status}}">Selected</option>
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>

                   </select>


                   <br>


            
                   <label for="description" class="form-label">category</label>

                
             <select class="form-control" name="category" >

               <option value="{{ $user->catId }}">Selected</option>
                   
             @foreach($countries as $country)
             <option value="{{ $country->categoryId }}" >{{ $country->catName }}</option>
            
               
               @endforeach
                   </select>


                 <br>


                 <div class="mb-3">
          
                    <input value="{{ $user->quantity }}" 
                        type="hidden" 
                        class="form-control" 
                        name="quantity" 
                        placeholder="" readonly >

                    @if ($errors->has('quantity'))
                        <span class="text-danger text-left">{{ $errors->first('quantity') }}</span>
                    @endif
                </div>


                <?php 
                  
                  $pricing = getusercompanyproductpricinginfo();
                  
           
                  ?>
            
            <div class="mb-3">
                 <label for="description" class="form-label">Cost Price</label>  
                    <input value="{{ $user->cprice }}" 
                        type="text" 
                        class="form-control" 
                        name="cprice" 
                        placeholder="" >

                    @if ($errors->has('cprice'))
                        <span class="text-danger text-left">{{ $errors->first('cprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                <label for="description" class="form-label">Product Barcode</label>  
                    <input value="{{ $user->barcodeinput }}" 
                        type="text" 
                        class="form-control" 
                        name="barcodeinput" 
                        placeholder="12674355" >

                    @if ($errors->has('barcodeinput'))
                        <span class="text-danger text-left">{{ $errors->first('barcodeinput') }}</span>
                    @endif
                </div>


          @if($pricing=="Multiple" )
         
          <div class="mb-3">
                 <label for="description" class="form-label">Unit Price</label>  
                    <input value="{{ $user->price }}" 
                        type="text" 
                        class="form-control" 
                        name="price" 
                        placeholder="" >

                    @if ($errors->has('price'))
                        <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                    @endif
                </div>


                
                <div class="mb-3">
                <label for="description" class="form-label">Whole Sale Price</label>  
                    <input value="{{ $user->whprice }}" 
                        type="text" 
                        class="form-control" 
                        name="whprice" 
                        placeholder="0.00" >

                    @if ($errors->has('whprice'))
                        <span class="text-danger text-left">{{ $errors->first('whprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                <label for="description" class="form-label">Bulk Whole Sale Price</label>  
                    <input value="{{ $user->bwhprice }}" 
                        type="text" 
                        class="form-control" 
                        name="bwhprice" 
                        placeholder="0.00" >

                    @if ($errors->has('whprice'))
                        <span class="text-danger text-left">{{ $errors->first('bwhprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                <label for="description" class="form-label">Promotional Whole Sale Price</label>  
                    <input value="{{ $user->pbwhprice }}" 
                        type="text" 
                        class="form-control" 
                        name="pbwhprice" 
                        placeholder="0.00" >

                    @if ($errors->has('pwhprice'))
                        <span class="text-danger text-left">{{ $errors->first('pbwhprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                <label for="description" class="form-label">Retail Price</label>  
                    <input value="{{ $user->rprice }}" 
                        type="text" 
                        class="form-control" 
                        name="rprice" 
                        placeholder="0.00" >

                    @if ($errors->has('rprice'))
                        <span class="text-danger text-left">{{ $errors->first('rprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                <label for="description" class="form-label">Promotional Retail Price</label>  
                    <input value="{{$user->prprice }}" 
                        type="text" 
                        class="form-control" 
                        name="prprice" 
                        placeholder="0.00">

                    @if ($errors->has('prprice'))
                        <span class="text-danger text-left">{{ $errors->first('prprice') }}</span>
                    @endif
                </div>
  
          @endif

          @if($pricing=="Single" )
         
  
          <div class="mb-3">
                 <label for="description" class="form-label">Unit Price</label>  
                    <input value="{{ $user->price }}" 
                        type="text" 
                        class="form-control" 
                        name="price" 
                        placeholder="" >

                    @if ($errors->has('price'))
                        <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                    @endif
                </div>


                
                <div class="mb-3">
                    <input value="{{ $user->whprice }}" 
                        type="hidden" 
                        class="form-control" 
                        name="whprice" 
                        placeholder="0.00" >

                    @if ($errors->has('whprice'))
                        <span class="text-danger text-left">{{ $errors->first('whprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                 
                    <input value="{{ $user->bwhprice }}" 
                        type="hidden" 
                        class="form-control" 
                        name="bwhprice" 
                        placeholder="0.00" >

                    @if ($errors->has('whprice'))
                        <span class="text-danger text-left">{{ $errors->first('bwhprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                
                    <input value="{{ $user->pbwhprice }}" 
                        type="hidden" 
                        class="form-control" 
                        name="pbwhprice" 
                        placeholder="0.00" >

                    @if ($errors->has('pwhprice'))
                        <span class="text-danger text-left">{{ $errors->first('pbwhprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
 
                    <input value="{{ $user->rprice }}" 
                        type="hidden" 
                        class="form-control" 
                        name="rprice" 
                        placeholder="0.00" >

                    @if ($errors->has('rprice'))
                        <span class="text-danger text-left">{{ $errors->first('rprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
               
                    <input value="{{$user->prprice }}" 
                        type="hidden" 
                        class="form-control" 
                        name="prprice" 
                        placeholder="0.00">

                    @if ($errors->has('prprice'))
                        <span class="text-danger text-left">{{ $errors->first('prprice') }}</span>
                    @endif
                </div>
         @endif
            
            

                </div>

                <br>
                <div class="mb-3">
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('product.index') }}" class="btn btn-default">Back</a>

                </div>
            </form>
        </div>

    </div>



@endsection