@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Warehouse details</h2>
        

        <div class="container mt-4">
            
            <form id="paymentForm" method="POST" action=" {{ route('warehouse.updatewarehouse', $user->warehouseId) }}" enctype="multipart/form-data" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
               

                  <input value="{{ $user->warehouseId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="branchId" id="email"
                        placeholder="" required>

                        <input value="{{$user->companyId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="companyId" id="email"
                        placeholder="" required>

                        <div class="mb-3">
                    <label for="title" class="form-label">Warehouse Name</label>
                    <input value="{{$user->warehouseName }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="" >

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Warehouse Phone Number</label>
                    <input value="{{$user->warehousePhone }}" 
                        type="text" 
                        class="form-control" 
                        name="phone" 
                        placeholder="" >

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('phone') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Location</label>
                    <input value="{{$user->location}}" 
                        type="text" 
                        class="form-control" 
                        name="location" 
                        placeholder="" >

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('location') }}</span>
                    @endif
                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('warehouse.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection