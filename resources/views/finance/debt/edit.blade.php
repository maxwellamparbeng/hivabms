@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Account details</h2>
        
        <div class="container mt-4">

        <form id="paymentForm" method="POST" action="{{ route('debt.update',$user->debtId) }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
       <input type="hidden" name="debtId" value="{{ $user->debtId }}">
     
          
           <div class="mb-3">
               <label for="title" class="form-label">Name</label>
               <input value="{{ $user->name }}" 
                   type="text" 
                   class="form-control" 
                   name="name" 
                   placeholder="" >

               @if ($errors->has('name'))
                   <span class="text-danger text-left">{{ $errors->first('name') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Amount Owed</label>
               <input value="{{ $user->amountOwed }}" 
                   type="text" 
                   class="form-control" 
                   name="amountOwed" 
                   placeholder="" >

               @if ($errors->has('amountOwed'))
                   <span class="text-danger text-left">{{ $errors->first('amountOwed') }}</span>
               @endif
           </div>



           <div class="mb-3">
               <label for="title" class="form-label">Amount Paid</label>
               <input value="{{ $user->amountPaid }}" 
                   type="text" 
                   class="form-control" 
                   name="amountPaid" 
                   placeholder="" >

               @if ($errors->has('amountPaid'))
                   <span class="text-danger text-left">{{ $errors->first('amountPaid') }}</span>
               @endif
           </div>



           <div class="mb-3">
               <label for="title" class="form-label">Description</label>
               <input value="{{ $user->description }}" 
                   type="text" 
                   class="form-control" 
                   name="description" 
                   placeholder="" >

               @if ($errors->has('description'))
                   <span class="text-danger text-left">{{ $errors->first('description') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Branch</label>
               <select name="branchId" class="form-select" id="" aria-label="State">
               <option value="{{$user->branchId}}">Selected</option> 
             @foreach ($branches as $recs) 

             <option value="{{ $recs->branchId }}"> {{ $recs->branchName }}

            </option>
             @endforeach 
                   </select>
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Status</label>
               <select name="status" class="form-select" id="" aria-label="State">
               <option value="{{$user->status}}">Selected</option>
               <option value="paid">Paid</option>
               <option value="unpaid">Unpaid
              </option>
              <option value="cancelled">Cancelled
              </option>
                   </select>
           </div>




           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Update</button>

         
       </form>

        </div>

    </div>



@endsection