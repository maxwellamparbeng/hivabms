@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('expense.add') )
   
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createpayrolls">Add new expense</button>
  
                         @endif



<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Expense </h5>
              
             


              <div class="modal fade" id="createpayrolls" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Expense </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                    <form id="paymentForm" method="POST" action=" {{ route('expense.store') }}" enctype="multipart/form-data" >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
         
     
          
           <div class="mb-3">
               <label for="title" class="form-label">Name</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="name" 
                   placeholder="" >

               @if ($errors->has('name'))
                   <span class="text-danger text-left">{{ $errors->first('name') }}</span>
               @endif
           </div>



           <div class="mb-3">
                    <label for="title" class="form-label">Category Type</label>
                    
            <select class="form-control" name="categoryId" >
            <option value="" >Choose category</option>
            @foreach($category as $cat)
            <option value="{{ $cat->expenseCategoryId }}" >{{ $cat->expenseCatName }}</option>
             @endforeach
             </select>
                 

                    @if ($errors->has('deductionId'))
                        <span class="text-danger text-left">{{ $errors->first('deductionId') }}</span>
                    @endif
                </div>



           <div class="mb-3">
               <label for="title" class="form-label">Description</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="description" 
                   placeholder="" >

               @if ($errors->has('description'))
                   <span class="text-danger text-left">{{ $errors->first('description') }}</span>
               @endif
           </div>



           
           <div class="mb-3">
               <label for="title" class="form-label">Amount</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amount" 
                   placeholder="" >

               @if ($errors->has('amount'))
                   <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
               @endif
           </div>





           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Save</button>

         
       </form>
                    </div>

                    </div>

                  </div>







              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Name</th>

                     
                     <th scope="col">Description</th>

                     <th scope="col">Category</th>
                     <th scope="col">Amount</th>
                     <th scope="col">Edit</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($expense as $rec)
                <tr>


               
                    <td>{{ $rec->expenseName }}</td>
                    <td>{{ $rec->description }}</td>
                    <td>{{ $rec->expenseCatName }}</td>
                    
                    <td>{{ $rec->amount }}</td>

                    @if(auth()->user()->can('expense.edit') )
   
                      <td><a href="{{ route('expense.edit', $rec->expenseId) }}" class="btn btn-info">Edit </a></td>
                        @endif
                   
                      
             </tr>
             @endforeach

                  
                   
                  
                
                 
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
          </div>
        </div>
      </div>
    </section>





   
    </div>

@endsection













