@extends('layouts.app-public')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add product</h2>
        <div class="container mt-4">
            <form id="paymentForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" >
       
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
                   
                    <input value="" 
                        type="hidden" 
                        class="form-control" 
                        name="quantity" 
                        placeholder="" >

                    @if ($errors->has('quantity'))
                        <span class="text-danger text-left">{{ $errors->first('quantity') }}</span>
                    @endif
                </div>


                <?php 
                  
                  $pricing = getusercompanyproductpricinginfo();
                  
           
                  ?>

             <div class="mb-3">
                 <label for="description" class="form-label">Cost Price</label>  
                    <input value="0.0" 
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
                    <input value="0.0" 
                        type="text" 
                        class="form-control" 
                        name="barcodeinput" 
                        placeholder="0.00" >

                    @if ($errors->has('barcodeinput'))
                        <span class="text-danger text-left">{{ $errors->first('barcodeinput') }}</span>
                    @endif
                </div>



          @if($pricing=="Multiple" )
          <div class="mb-3">
                 <label for="description" class="form-label">Unit Price</label>  
                    <input value="0.0" 
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
                    <input value="0.0" 
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
                    <input value="0.0" 
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
                    <input value="0.0" 
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
                    <input value="0.0" 
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
                    <input value="0.0" 
                        type="text" 
                        class="form-control" 
                        name="prprice" 
                        placeholder="0.00"  >

                    @if ($errors->has('prprice'))
                        <span class="text-danger text-left">{{ $errors->first('prprice') }}</span>
                    @endif
                </div>
  
          @endif

          @if($pricing=="Single" )
          <div class="mb-3">
                 <label for="description" class="form-label">Unit Price</label>  
                    <input value="0.0" 
                        type="text" 
                        class="form-control" 
                        name="price" 
                        placeholder="" >

                    @if ($errors->has('price'))
                        <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                    @endif
                </div>


                
                <div class="mb-3">
               
                    <input value="0.0" 
                        type="hidden" 
                        class="form-control" 
                        name="whprice" 
                        placeholder="0.00" >

                    @if ($errors->has('whprice'))
                        <span class="text-danger text-left">{{ $errors->first('whprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
       
                    <input value="0.0" 
                        type="hidden" 
                        class="form-control" 
                        name="bwhprice" 
                        placeholder="0.00" >

                    @if ($errors->has('whprice'))
                        <span class="text-danger text-left">{{ $errors->first('bwhprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                
                    <input value="0.0" 
                        type="hidden" 
                        class="form-control" 
                        name="pbwhprice" 
                        placeholder="0.00" >

                    @if ($errors->has('pwhprice'))
                        <span class="text-danger text-left">{{ $errors->first('pbwhprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                
                    <input value="0.0" 
                        type="hidden" 
                        class="form-control" 
                        name="rprice" 
                        placeholder="0.00" >

                    @if ($errors->has('rprice'))
                        <span class="text-danger text-left">{{ $errors->first('rprice') }}</span>
                    @endif
                </div>


                <div class="mb-3">
           
                    <input value="0.0" 
                        type="hidden" 
                        class="form-control" 
                        name="prprice" 
                        placeholder="0.00"  >

                    @if ($errors->has('prprice'))
                        <span class="text-danger text-left">{{ $errors->first('prprice') }}</span>
                    @endif
                </div>
  
          @endif

               

                 


                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Add</button>

                <a href="{{ route('product.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection