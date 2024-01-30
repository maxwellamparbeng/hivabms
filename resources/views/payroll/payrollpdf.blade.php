@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       



<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Payroll</h5>
              
        
                </div>


              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                     
                     <th scope="col">Ref No</th>

                     

                     <th scope="col">Employee Name</th>


                     <th scope="col">Employee Code</th>

                     <th scope="col">From</th>

                     <th scope="col">To</th>

                     <th scope="col">Salary</th>

                     <th scope="col">Attendance</th>

                     <th scope="col">Deduction</th>

                     <th scope="col">Allowance</th>

                     <th scope="col">Net</th>

                     <th scope="col">Income Tax</th>
                    
                     <th scope="col">SSNIT</th>
                     
                    
                  </tr>
                </thead>
                <tbody>

                @foreach ($records as $rec)
                <tr>


                    <td>{{ $rec->payrollId  }}</td>

                    <td>{{ $rec->employeeName  }}</td>

                    <td>{{ $rec->empCode  }}</td>

                    <td>{{ $rec->date_from }}</td>

                    <td>{{ $rec->date_to }}</td>

              
<?php  $payroll = displaypayrolldetails($rec->employeeId,$rec->payrollId );?>

<td>{{ $payroll['salary'] }}</td>
<td>{{ $payroll['present'] }}</td>
<td>{{ $payroll['deductionAmount'] }}</td>
<td>{{ $payroll['allowanceAmount'] }}</td>
<td>{{ $payroll['net'] }}</td> 
<td>{{ $payroll['incomeTax'] }}</td> 
<td>{{ $payroll['ssnit'] }}</td> 










                  

                    @if(auth()->user()->can('payroll.payroll') )

                    <a href="{{ route('payroll.payrollpdf',$rec->ref_no) }}" class="btn btn-primary">Generate pdf</a>
                  
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













