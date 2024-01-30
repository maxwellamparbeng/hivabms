@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
       
     <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">


          @if(auth()->user()->can('client.index') )
   <!-- Sales Card -->
   <div class="col-xxl-3 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                 
                  </ul>
                </div>

    

                <div class="card-body">
                  <h5 class="card-title">Transactions<span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $transactions }}</h6>
                      <span class="text-success small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>

                    </div>
                  </div>
                </div>

              </div>
            </div>



  @endif
  

           


            @if(auth()->user()->can('company.sendsms') )
  

              <!-- Revenue Card -->
              <div class="col-xxl-3 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                  
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Balance(GHS) <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-send-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $balance }}</h6>
                      <span class="text-success small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->


  @endif
  

           




            @if(auth()->user()->can('company.sendsms') )
  
            <div class="col-xxl-3 col-md-6">

<div class="card info-card customers-card">

  <div class="filter">
    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
      <li class="dropdown-header text-start">
        <h6>Filter</h6>
      </li>

      <li><a class="dropdown-item" href="#">Today</a></li>
  
    </ul>
  </div>

  <div class="card-body">
    <h5 class="card-title">Payment links <span></span></h5>

    <div class="d-flex align-items-center">
      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
        <i class="bi bi-wallet2"></i>
      </div>
      <div class="ps-3">
        <h6>{{ $paymentlinks }}</h6>
        <span class="text-sucess small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>

      </div>
    </div>

  </div>
</div>

</div><!-- End Customers Card -->

@endif

            </div>
            </div>




<div class="row">




<div class="col-md-6">

<div class="card">
            <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Transaction Id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Currency</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                    </tr>
                  </thead>
                  <tbody>
              

                  <?php 
                               

                               
                 
                  $encode= json_encode( $alltransactions);
                  $decode= json_decode($encode,true);
                  
                                foreach ($decode as $res) {
                                  
                                  $id=$res['transactionId'];
                                  $senderUserId=$res['senderUserId'];
                                  $senderPhoneNumber=$res['senderPhoneNumber'];
                                  $senderUsername=$res['senderUsername'];
                                  $receiverUserId=$res['receiverUserId'];
                                  $receiverUsername=$res['receiverUsername'];
                                  $receiverPhoneNumber=$res['receiverPhoneNumber'];
                                  $amount=$res['amount'];
                                  $dateCreated=$res['dateCreated'];
      
                                  $statusname=$res['statusName'];
                                  $currency=$res['currency'];
                                
                                
                                  echo "<tr>";
                                  echo "<td>".$id."</td>";
                                  echo "<td>".$amount."</td>";
                                  echo "<td>".$currency."</td>";
              
                                  echo "<td>". $dateCreated."</td>";
                                  
                                
                                  echo "</tr>";
                                }
                            ?>
             



                  </tbody>
                </table>
              </div>


              </div>
              </div>

              </div>

<div class="col-md-6">
            <div id="container2" style="width: 700px; height: 400px;">
        
       
        
        </div>
            </div>
            
            </div>


            </div>
</section>   

    


    

            <!-- End Sales Card -->


            


    

    </div>



   
         
         <script language = "JavaScript">
            function drawChart() {
               // Define the chart to be drawn.
               var data = new google.visualization.DataTable();
               data.addColumn('string', 'Transaction');
               data.addColumn('number', 'Percentage');
               data.addRows([
                 
                      
                       <?php


$encode= json_encode($charts);
$decode= json_decode($encode,true);

foreach($decode as $res) { //foreach element in $arr
  

  echo "['".$res["transactionName"]."', ".$res["count"]."],";  


  }



   
   
               ?>       
                   
                 
                 
               ]);
                  
               // Set chart options
               var options = {
                  'title':'Transactions ,<?php echo date("Y");?>',
                  is3D: true
               };
   
               // Instantiate and draw the chart.
               var chart = new google.visualization.PieChart(document.getElementById('container2'));
               chart.draw(data, options);
            }
            google.charts.setOnLoadCallback(drawChart);
         </script>
   

@endsection
