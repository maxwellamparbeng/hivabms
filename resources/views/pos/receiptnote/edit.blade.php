@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Receipt Note details</h2>
        

        <div class="container mt-4">
            
            <form id="paymentForm" method="POST" action=" {{ route('receipt.updatenote', $user->noteId) }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
               

                  <input value="{{ $user->noteId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="noteId" id="email"
                        placeholder="" required>

                        <div class="mb-3">
                    <label for="title" class="form-label">Receipt Note</label>
                   
                    <textarea name="note" class="form-control" placeholder="Invoice note" id="floatingTextarea" style="height: 100px;">{{$user->note}}</textarea>
                   

                    @if ($errors->has('note'))
                        <span class="text-danger text-left">{{ $errors->first('note') }}</span>
                    @endif
                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('receipt.managereceiptnote') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection