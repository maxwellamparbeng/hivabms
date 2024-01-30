@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit vat details</h2>
        

        <div class="container mt-4">
            
            <form id="paymentForm" method="POST" action=" {{ route('pos.updatevat', $user->vatId) }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
               

                  <input value="{{ $user->vatId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="vatId" id="email"
                        placeholder="" required>


                        <div class="mb-3">
                    <label for="title" class="form-label">Name</label>
                   
                    <input value="{{$user->name}}" 
                        type="text" 
                        class="form-control" 
                        name="name" id="email"
                        placeholder="" required>

              

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>







                        <div class="mb-3">
                    <label for="title" class="form-label">Rate</label>
                   
                    <input value="{{$user->rate}}" 
                        type="text" 
                        class="form-control" 
                        name="rate" id="email"
                        placeholder="" required>

              

                    @if ($errors->has('rate'))
                        <span class="text-danger text-left">{{ $errors->first('rate') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                <label for="title" class="form-label">Levy / vat ?</label>
                <select name="vatType" class="form-select" id="js-example-basic-single" aria-label="State">
                <option value="{{$user->vatType}}">Selected</option> 
                 <option value="vat">Flat Rate</option>
                 <option value="Levy">Levy</option>
                </select>

                   </div>



                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('receipt.managereceiptnote') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection