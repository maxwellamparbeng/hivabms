@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('pos.addvat') )
   
    <a href="{{ route('pos.addvat') }}" class="btn btn-info">Add Vat</a>  
                         @endif



<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Vate / Levies</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                     <th scope="col">Rate</th>
                     <th scope="col">Type</th>
                  
                     <th scope="col">Edit</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($note as $rec)
                <tr>


                    <td>{{ $rec->vatId }}</td>
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->rate }}</td>
                    <td>{{ $rec->vatType }}</td>
              
                    @if(auth()->user()->can('pos.editvat') )
   
                    <td><a href="{{ route('pos.editvat', $rec->vatId) }}" class="btn btn-info">Edit </a></td>
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













