@extends('layouts.app-public')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Booking details</h2>
        

        <div class="container mt-4">




      

            <form id="paymentForm" method="POST" action=" {{ route('booking.update', $user->bookingId) }}" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
                <div class="mb-3">
                    <label for="title" class="form-label">Email</label>
                    <input value="{{ $user->email }}" 
                        type="text" 
                        class="form-control" 
                        name="email" id="email"
                        placeholder="" required>

                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <input value="{{ $user->bookingId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="email" id="email"
                        placeholder="" required>



                    <select class="form-control" name="bookingStatus">
                        <option value="In progress">In progress</option>
                        <option value="Completed">Completed</option>

                   </select>


                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('booking.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection