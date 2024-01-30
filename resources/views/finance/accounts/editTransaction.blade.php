@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Transaction details</h2>
        
        <div class="container mt-4">

        <form id="paymentForm" method="POST" action="{{ route('account.updatetransaction', $user->accountTransactionsId) }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
       <input type="hidden" name="transactionId" value="{{ $user->accountTransactionsId }}">
     


           <div class="mb-3">
               <label for="title" class="form-label">Account</label>
              
               <select name="accountId" class="form-select" id="" aria-label="State">
                <option value="{{ $user->accountId }}">Selected</option> 
             @foreach ($accounts as $rec) 

             <option value="{{ $rec->accountId }}"> {{ $rec->name }}

            </option>
             @endforeach 
                   </select>
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Amount</label>
               <input value="{{ $user->amount }}" 
                   type="text" 
                   class="form-control" 
                   name="amount" 
                   placeholder="" >

               @if ($errors->has('amount'))
                   <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
               @endif
           </div>



           <div class="mb-3">
               <label for="title" class="form-label">Description</label>
               <input value="{{ $user->transDescription }}" 
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
               <label for="title" class="form-label">Transaction Type</label>
               <select name="transType" class="form-select" id="" aria-label="State">
                <option value="{{ $user->transType }}">Selected</option> 
               <option value="Inflow">Inflow
               <option value="Outflow">Outflow
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