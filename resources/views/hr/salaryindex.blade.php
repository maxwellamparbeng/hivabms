@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('productcategory.add') )
   
    <a href="{{ route('productcategory.add') }}" class="btn btn-info">Add Salary</a>  
                         @endif



<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Jobs</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Salary Amount</th>
                     
                     <th scope="col">Edit</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>


               
                    <td>{{ $rec->salaryName }}</td>
                  

                    @if(auth()->user()->can('hr.editSalary') )
   
                    <td><a href="{{ route('hr.editSalary', $rec->salaryId) }}" class="btn btn-info">Edit </a></td>
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













