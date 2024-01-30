@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        
    @if(auth()->user()->can('payroll.addDeduction') )
   
    <a href="{{ route('payroll.addDeduction') }}" class="btn btn-info">Add Deduction</a>  
                         @endif

<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Deduction</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Deductions</th>

                     <th scope="col">Description</th>
                     
                     <th scope="col">Edit</th>

               
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>

                    <td>{{ $rec->deduction }}</td>
                   
                    <td>{{ $rec->description}}</td>
                   

                    @if(auth()->user()->can('payroll.editDeduction') )
   
                    <td><a href="{{ route('payroll.editDeduction', $rec->deductionId) }}" class="btn btn-info">Edit </a></td>
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













