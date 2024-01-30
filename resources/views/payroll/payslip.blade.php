@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       



<section class="section">
      <div class="row">
        <div class="col-lg-12">

        <a href="javascript:;" onclick="window.print()"  class="btn btn-secondary">
											<i class="icon-printer"></i> Print

</a>


        @foreach ($records as $rec) 



        <div class="container mt-5 mb-5 card">
            <br>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center lh-1 mb-2">
                <h6 class="fw-bold">Payslip</h6> <span class="fw-normal">Payment slip for {{ $rec->date_from }} to 
{{ $rec->date_to }}</span>
            </div>
            <div class="d-flex justify-content-end"> 
        
        

        
        </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3">
                            <br>
                            <div> <span class="fw-bolder">EMP Code-</span> <small class="ms-3">{{ $rec->empCode  }}</small> </div>

                            <span class="fw-bolder">EMP Name-</span> <small class="ms-3">{{ $rec->employeeName  }}</small>

                            <span class="fw-bolder">Designation-</span> <small class="ms-3">{{ $rec->jobName }}</small> 
                        </div>
                        <div class="col-md-6">
                            <div>  </div>
                        </div>

                        <div class="col-md-3">
                            
                        
                            <?php  $company= companyinfo();




echo"</br> ";
            echo"<span>Company Name: ".$company['name']." </span> ";

            echo"</br> ";
            echo"<span>Email: ".$company['email']." </span> ";
            echo"</br> ";
            echo"<span>Phone: ".$company['phone']." </span> ";
            
            ?>
                        
                        
                        
                        </div>
                        </div>

                       


                    </div>


                   
                  
                    <div class="row">
                        <div class="col-md-6">
                            <div>  </div>
                        </div>
                     
                    </div>


                   

                </div>




                <div class="row">
                        <div class="col-md-6">
                        <hr>
                        
                        
                            <div> <span class="fw-bolder">Allowance</span> <small class="ms-3"></small> 
                        
                        
                            <table class="mt-4 table table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">Allowance</th>
                            <th scope="col">Description</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                    
                    <?php  $payroll = displaypayrolldetails($rec->employeeId,$rec->payrollId );?>
                    
                    
                    @foreach ( json_decode( $payroll['allowance'], true ) as $allow)
                        <tr>
                        <td>{{ $allow['allowance'] }}</td>
                       <td>{{ $allow['description'] }}</td>
                       <td>{{ $allow['amount'] }}</td>

                       </tr>
                    

                    @endforeach

                
                    <tr class="border-top">
                            
                            <td></td>
                                    <td></td>
                                    <td>Total:
        
                                    <?php  $payroll = displaypayrolldetails($rec->employeeId,$rec->payrollId );
                                    
                                    echo $payroll['allowanceAmount'];
                                    
                                    ?>
                                    
                                  
        
        
                                    </td>
                                </tr>


                    </tbody>
                </table>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        </div>
                        </div>







                        <div class="col-md-6">
                        <hr>
                            <div> <span class="fw-bolder">Deductions</span> <small class="ms-3"></small> 
                            
                        
                            <table class="mt-4 table table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">Deduction</th>
                            <th scope="col">Description</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                    
                    <?php  $payroll = displaypayrolldetails($rec->employeeId,$rec->payrollId );?>
                    
                    
                    @foreach ( json_decode( $payroll['deduction'], true ) as $deduct)
                        <tr>
                        <td>{{ $deduct['deduction'] }}</td>
                       <td>{{ $deduct['description'] }}</td>
                       <td>{{ $deduct['amount'] }}</td>

                       </tr>
                    

                    @endforeach


                    
                    <?php  $payroll = displaypayrolldetails($rec->employeeId,$rec->payrollId );
                            
                          //  echo $payroll['deductionAmount'];

                            ?>

                            <tr>
                            
                            <td>SSNIT</td>
                           <td>SSNIT contribution for employee</td>
                           <td><?php echo $payroll['ssnit'];?></td>
    
                           </tr>


                           <tr>
                            
                            <td>Income Tax</td>
                           <td>Income Tax for employee</td>
                           <td><?php echo $payroll['incomeTax'];?></td>
    
                           </tr>



                            
                 




      


                    <tr class="border-top">
                            
                    <td></td>
                            <td></td>
                            <td>Total:

                            <?php  $payroll = displaypayrolldetails($rec->employeeId,$rec->payrollId );
                            
                            echo $payroll['deductionAmount']+$payroll['ssnit']+$payroll['incomeTax'];
                            
                            ?>
                            
                          


                            </td>
                        </tr>

                



                    </tbody>
                </table>
                        
                        
                        
                        
                        </div>
                        </div>
                    </div>


            </div>
            <div class="row">
                <div class="col-md-4"> <br> <span class="fw-bold">Net Pay : {{ $payroll['netSalary'] }}</span> </div>
                <div class="border col-md-8">
                    <div class="d-flex flex-column"> <span>In Words</span> <span> <?php  echo $payroll = numberTowords($payroll['netSalary']) ;
                            
                            // echo $payroll['deduction']->sum('amount');
                            
                            ?>             </span> </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <div class="d-flex flex-column mt-2"> <span class="fw-bolder">HR </span> <span class="mt-4">Authorised Signatory</span> </div>
            </div>
        </div>
    </div>
</div>



     
                
@endforeach
    


        


          </div>
        </div>
      </div>
    </section>






   





   
    </div>

@endsection













