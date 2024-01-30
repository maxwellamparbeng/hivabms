@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add Receipt Note </h2>
        

        <div class="container mt-4">


        
         
      

            <form id="paymentForm" method="POST" action=" {{ route('receipt.storeNote') }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
                 
                <div class="mb-3">
                    <label for="title" class="form-label">Receipt Note</label>
                   
                    <textarea name="note" class="form-control" placeholder="Invoice note" id="floatingTextarea" style="height: 100px;"></textarea>
                   

                    @if ($errors->has('note'))
                        <span class="text-danger text-left">{{ $errors->first('note') }}</span>
                    @endif
                </div>


               


                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Add</button>

                <a href="{{ route('receipt.managereceiptnote') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection