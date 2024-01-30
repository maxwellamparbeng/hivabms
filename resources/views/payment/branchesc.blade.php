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
              <h5 class="card-title">Branches</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Name</th>
                     <th scope="col">Phone</th>
                     <th scope="col">Location</th>
                     
                     
                     <th scope="col">Login</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>


               
                    <td>{{ $rec->branchName }}</td>
                    <td>{{ $rec->branchPhone }}</td>
                    <td>{{ $rec->location }}</td>

                    @if(auth()->user()->can('hivapay.login') )
   
                    <td><a href="{{ route('hivapay.login', $rec->branchId) }}" class="btn btn-info">Login</a></td>
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













