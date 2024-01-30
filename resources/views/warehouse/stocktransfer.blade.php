@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
    
@if(auth()->user()->can('warehouse.transferstocklog') )
<a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal">Generate Report</a>
@endif


     
<br>
<br> 

<section class="section">


      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Warehouse Inventory Transfer Report</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     <th scope="col">Image</th>
                    <th scope="col">Product Id</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Warehouse name</th>
                    <th scope="col">Branch name</th>
                    <th scope="col">Action By</th>
                    
                    <th scope="col">Date</th>
                   
                    
                   
                  </tr>
                </thead>
                <tbody>

                @foreach ($details as $rec)

                <tr>
                
               
                @if (empty($rec->pic) )
                <th scope="row"><img height="50px" width="100px" src="/storage/dummy.jpg" alt="" title=""></th>
                 @else
                 <th scope="row"><img height="50px" width="100px" src="{{Storage::url($rec->pic)}}" alt="" title=""></th>
                @endif
                
                
                    <th scope="row">{{ $rec->productId }}</th>
                    <td>{{ $rec->name }}</td>
                    <td>{{ $rec->quantity }}</td>
                    <td>{{ $rec->warehouseName }}</td>
                    <td>{{ $rec->branchName }}</td>
                    <td>{{ $rec->username }}</td>
                    <td>{{ $rec->dateCreated }}</td>
                    </tr>


                    
             @endforeach

              
        
                </tbody>
              </table>

              

<div class="modal fade" id="basicModal" tabindex="-1">
<div class="modal-dialog">
 <div class="modal-content">
   <div class="modal-header">
     <h5 class="modal-title">Transfer Report</h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-body">
   
   <form name="" action="{{ route('warehouse.transferstocklog') }}" method="GET" class="row g-3">

@csrf
<input type="hidden" id="_token" value="{{ csrf_token() }}">
<input type="hidden" name="branch" value="">

<div class="col-md-6">
 <p>Start Date</p>
<input type="date" name="from" class="form-control">
</div>

<br>


<div class="col-md-6">
<p>End Date</p>
<input type="date" name="to" class="form-control">
 
</div>


<div class="col-md-6">
<p>Type of Report</p>
<select name="reportType" required class="form-control"  aria-label="State">
<option value="">Select Report Type</option>
<option value="Web">Web page</option>
<option value="csv">CSV</option>

</select>
 
</div>


<div class="col-md-6">

<p>Warehouse</p>
<select name="warehouseId" required class="form-select"  aria-label="State">
                <option value="">Select Warehouse</option> 
 <option value="All">All</option>
 @foreach ($warehouse as $key => $value) 

<option value="{{ $key }}"> {{ $value }}

</option>
</div>



  @endforeach 
                   </select>

  
 
</div>

    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
     <button type="submit" class="btn btn-info" >Generate</button>
     </form>
   </div>

 </div>
</div>


</div>


               
              <!-- End Table with stripped rows -->

            </div>
          </div>
          </div>
        </div>
      </div>
    </section>





   
    </div>

@endsection













