@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
    

<br>
<br> 




<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Payroll</h5>
              
              <form id="paymentForm" method="POST" action=" {{ route('payroll.createPayroll') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
           
              <div class="mb-3">
               <label for="title" class="form-label">Deduction Name</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="deduction" 
                   placeholder="" >

               @if ($errors->has('deduction'))
                   <span class="text-danger text-left">{{ $errors->first('deduction') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Deduction Description</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="description" 
                   placeholder="" >

               @if ($errors->has('description'))
                   <span class="text-danger text-left">{{ $errors->first('description') }}</span>
               @endif
           </div>

           


           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Add</button>

           <a href="{{ route('payroll.allDeduction') }}" class="btn btn-default">Back</a>
       </form>



          </div>
          </div>
        </div>
      </div>
    </section>






   





   
    </div>

@endsection













