
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
                  <h5 class="card-title">Clients<span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $clients }}</h6>
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
                  <h5 class="card-title">Campaign <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-send-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $campaigns }}</h6>
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
    <h5 class="card-title">Sms Balance <span></span></h5>

    <div class="d-flex align-items-center">
      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
        <i class="bi bi-wallet2"></i>
      </div>
      <div class="ps-3">
        <h6>{{ $smsbalance }}</h6>
        <span class="text-sucess small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>

      </div>
    </div>

  </div>
</div>

</div><!-- End Customers Card -->

@endif


           





@if(auth()->user()->can('product.index') )
  

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
    <h5 class="card-title">Products <span></span></h5>

    <div class="d-flex align-items-center">
      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
        <i class="bi bi-bag-fill"></i>
      </div>
      <div class="ps-3">
        <h6>{{ $product }}</h6>
        <span class="text-default small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>

      </div>
    </div>

  </div>
</div>

</div><!-- End Customers Card -->

@endif



@if(auth()->user()->can('invoice.index') )
  
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
    <h5 class="card-title">Invoice<span></span></h5>

    <div class="d-flex align-items-center">
      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
        <i class="bi bi-receipt-cutoff"></i>
      </div>
      <div class="ps-3">
        <h6>{{ $invoice }}</h6>
        <span class="text-danger small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>

      </div>
    </div>

  </div>
</div>

</div><!-- End Customers Card -->
        

@endif





@if(auth()->user()->can('hr.allEmployees') )
  
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
    <h5 class="card-title">Employees<span></span></h5>

    <div class="d-flex align-items-center">
      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
        <i class="bi bi-person-bounding-box"></i>
      </div>
      <div class="ps-3">
        <h6>{{ $employees }}</h6>
        <span class="text-danger small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>

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
            <div id="curve_chart" style="width: 700px; height: 400px;"></div>
            </div>
            </div>


            </div>
</section>   

    


    

            <!-- End Sales Card -->


            


    

    </div>



    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
      //   var data = google.visualization.arrayToDataTable([
      //     ['Year', 'Sales', 'Expenses'],
      //     ['2004',  1000,      400],
      //     ['2005',  1170,      460],
      //     ['2006',  660,       1120],
      //     ['2007',  1030,      540]
      //   ]);


      var data = google.visualization.arrayToDataTable([
            ['Year', 'totalSent'],
 
            @php

           
              foreach($campaignchart as $order) {
              
                $year = explode('-', $order->dateCreated)[0];

                  echo "['".$year."', ".$order->totalSent."],";
              }
            @endphp
        ]);

      

        var options = {
          title: 'Sms Campaigns',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>


@endsection










