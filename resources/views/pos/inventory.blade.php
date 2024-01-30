@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('branch.add') )
   
    <a href="{{ route('branch.add') }}" class="btn btn-info">Add new branch</a>  
                         @endif



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
                     <th scope="col">Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>


               
                    <td>{{ $rec->branchName }}</td>
                    <td>{{ $rec->branchPhone }}</td>
                    <td>{{ $rec->location }}</td>

                    @if(auth()->user()->can('pos.branchinventory') )
   
                    <td><a href="{{ route('pos.branchinventory', $rec->branchId) }}" class="btn btn-info">Manage</a>
                  

                    @if(auth()->user()->can('pos.cancelreceipt') )
    
                 
   
    <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal{{$rec->branchId}}">Logs</a>
   
  
                    @endif
                  
                    @if(auth()->user()->can('pos.exportInventory') )
   
     <a href="{{ route('pos.exportInventory', $rec->branchId) }}" class="btn btn-info">Export</a></td>
         
   
              @endif
                  

                  </td>
                      
         



                    
                    @endif
                   
                       
                  
                <div class="modal fade" id="basicModal{{ $rec->branchId }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Inventory Log</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                    <form name="" action="{{ route('pos.exportInventoryLog') }}" method="POST" class="row g-3">
               
               @csrf
             <input type="hidden" id="_token" value="{{ csrf_token() }}">
             <input type="hidden" name="branch" value="{{ $rec->branchId }}">
             
                 <div class="col-md-6">
                  <p>Start Date</p>
                 <input type="date" name="from" class="form-control">
                 </div>
 
                 <br>
 
                  
 
 
                 <div class="col-md-6">
                 <p>End Date</p>
                 <input type="date" name="to" class="form-control">
                  
                 </div>
 
                   
                  
                 </div>

             
                   
                   
                   
                   
                     <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info" >Generate</button>
                      </form>
                    </div>

                  </div>
                </div>
                

    </div>
                  
                      
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













