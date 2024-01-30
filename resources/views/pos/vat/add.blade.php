@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add vate rate </h2>
        

        <div class="container mt-4">


        
         
      

            <form id="paymentForm" method="POST" action=" {{ route('pos.storevat') }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
                
            <div class="mb-3">
                    <label for="title" class="form-label">Name of Vat/Levy</label>
                   
                    <input  name="name" type="text" class="form-control" id="floatingTextarea">
                 

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>


                 
                <div class="mb-3">
                    <label for="title" class="form-label">Rate</label>
                   
                    <input  name="rate" type="text" class="form-control" id="floatingTextarea">
                 

                    @if ($errors->has('rate'))
                        <span class="text-danger text-left">{{ $errors->first('rate') }}</span>
                    @endif
                </div>


               
                <div class="mb-3">
                <label for="title" class="form-label">Levy / vat ?</label>
                <select name="vatType" class="form-select" id="js-example-basic-single" aria-label="State">
                 <option value="vat">Flat Rate</option>
                 <option value="Levy">Levy</option>
                </select>

                   </div>


                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Add</button>

                <a href="{{ route('pos.managevatsetup') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection