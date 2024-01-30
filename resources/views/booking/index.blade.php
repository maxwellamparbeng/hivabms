@extends('layouts.app-public')

@section('content')
    <div class="bg-light p-4 rounded">
       
        <div class="lead">
            Add new booking
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('booking.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">First name</label>
                    <input value="@if(session()->has('fName')){{ session()->get('fName') }}
   @else   
   @endif " 
                        type="text" 
                        class="form-control" 
                        name="firstName" 
                        placeholder="" required>

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('firstName') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Last name</label>
                    <input value="@if(session()->has('lName')){{ session()->get('lName') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="lastName" 
                        placeholder="" required>

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('lastName') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Email</label>
                    <input value="@if(session()->has('email')){{ session()->get('email') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="email" 
                        placeholder="" required>

                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Phone Number</label>
                    <input value="@if(session()->has('email')){{ session()->get('phoneNumber') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="phoneNumber" 
                        placeholder="" required>

                    @if ($errors->has('phoneNumber'))
                        <span class="text-danger text-left">{{ $errors->first('phoneNumber') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Research Topic</label>
                    <input value="@if(session()->has('email')){{ session()->get('researchTopic') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="researchTopic" 
                        placeholder="" required>

                    @if ($errors->has('researchTopic'))
                        <span class="text-danger text-left">{{ $errors->first('researchTopic') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Discipline</label>
                    <input value="@if(session()->has('email')){{ session()->get('discipline') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="discipline" 
                        placeholder="" required>

                    @if ($errors->has('discipline'))
                        <span class="text-danger text-left">{{  $errors->first('discipline') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Level of Research</label>
                    <input value="@if(session()->has('email')){{ session()->get('levelofResearch') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="levelofResearch" 
                        placeholder="" required>

                    @if ($errors->has('discipline'))
                        <span class="text-danger text-left">{{ $errors->first('discipline') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Problem Description</label>
                    <textarea class="form-control" 
                        name="problemDescription" 
                        placeholder="What do you want solved ?" required>
                     @if(session()->has('email')){{ session()->get('levelofResearch') }}
   @else   
   @endif
                    
                    
                    </textarea>

                    @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('problemDescription') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Service</label>
                    <input value="@if(session()->has('email')){{ session()->get('service') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="service" 
                        placeholder="Title" required>

                    @if ($errors->has('service'))
                        <span class="text-danger text-left">{{ $errors->first('service') }}</span>
                    @endif
                </div>

             

                <button type="submit" class="btn btn-primary">Next</button>
                <a href="{{ route('booking.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection