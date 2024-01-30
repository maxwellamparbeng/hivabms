@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        

    

    @if(auth()->user()->can('warehouse.add') )
   
    <a href="{{ route('warehouse.add') }}" class="btn btn-info">Add warehouse </a>  
                         @endif



<br>
<br> 

<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Warehouses</h5>
              
             

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
                    <td>{{ $rec->warehouseName }}</td>
                    <td>{{ $rec->warehousePhone }}</td>
                    <td>{{ $rec->location }}</td>

                    <td>

                   
   <div class="btn-group">
  
   <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>


  <d iv class="dropdown-menu">
    
  @if(auth()->user()->can('warehouse.edit') )

  
  <a href="{{ route('warehouse.edit', $rec->warehouseId) }}" class="dropdown-item">Edit </a>
  @endif



  @if(auth()->user()->can('warehouse.inventory') )
   
 <a href="{{ route('warehouse.inventory', $rec->warehouseId) }}" class="dropdown-item">Manage</a>
 
   @endif


   @if(auth()->user()->can('warehouse.exportInventory') )

<a href="{{ route('warehouse.exportInventory', $rec->warehouseId) }}" class="dropdown-item">Export</a>
  
@endif


@if(auth()->user()->can('warehouse.exportInventoryLog') )
<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#basicModal{{$rec->warehouseId}}">Logs</a>
@endif


</div>





    
 </td>
     




   

  
      
 
<div class="modal fade" id="basicModal{{ $rec->warehouseId }}" tabindex="-1">
<div class="modal-dialog">
 <div class="modal-content">
   <div class="modal-header">
     <h5 class="modal-title">Inventory Log</h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-body">
   
   <form name="" action="{{ route('warehouse.exportInventoryLog') }}" method="POST" class="row g-3">

@csrf
<input type="hidden" id="_token" value="{{ csrf_token() }}">
<input type="hidden" name="branch" value="{{ $rec->warehouseId }}">

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













