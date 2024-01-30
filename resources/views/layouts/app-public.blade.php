<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Research Coach</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{!! url('assets/img/favicon.png') !!}" rel="icon">
  <link href="{!! url('assets/img/apple-touch-icon.png') !!}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{!! url('assets/vendor/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
  <link href="{!! url('assets/vendor/bootstrap-icons/bootstrap-icons.css') !!}" rel="stylesheet">
  <link href="{!! url('assets/vendor/boxicons/css/boxicons.min.css') !!}" rel="stylesheet">
  <link href="{!! url('assets/vendor/quill/quill.snow.css') !!}" rel="stylesheet">
  <link href="{!! url('assets/vendor/quill/quill.bubble.css') !!}" rel="stylesheet">
  <link href="{!! url('assets/vendor/remixicon/remixicon.css') !!}" rel="stylesheet">
  <link href="{!! url('assets/vendor/simple-datatables/style.css') !!}" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="{!! url('assets/css/style.css') !!}" rel="stylesheet">


  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    
  
 @include('layouts.partials.publicnavbar')
     <main id="main" class="main">
       
     @yield('content')

    </main>

     <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
    
    </div>
    <div class="credits">
 
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>




  <!-- Vendor JS Files -->

  <script src="{!! url('assets/vendor/simple-datatables/simple-datatables.js') !!}"> </script>
  <script src="{!! url('assets/vendor/apexcharts/apexcharts.min.js') !!}"></script>
  <script src="{!! url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
  <script src="{!! url('assets/vendor/chart.js/chart.min.js') !!}"></script>
  <script src="{!! url('assets/vendor/echarts/echarts.min.js') !!}"></script>
  <script src="{!! url('assets/vendor/quill/quill.min.js') !!}"></script>
  <script src="{!! url('assets/vendor/simple-datatables/simple-datatables.js') !!}"></script>
  <script src="{!! url('assets/vendor/tinymce/tinymce.min.js') !!}"></script>
  <script src="{!! url('assets/vendor/php-email-form/validate.js') !!}"></script>

  <!-- Template Main JS File -->
  <script src="{!! url('assets/js/main.js') !!}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    

    <style type="text/css">

.output {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}
.smartphone {
  position: relative;
  width: 250px;
  height: 500px;
  margin: auto;
  border: 16px black solid;
  border-top-width: 60px;
  border-bottom-width: 60px;
  border-radius: 36px;
}

/* The horizontal line on the top of the device */
.smartphone:before {
  content: '';
  display: block;
  width: 60px;
  height: 5px;
  position: absolute;
  top: -30px;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #333;
  border-radius: 10px;
}

/* The circle on the bottom of the device */
.smartphone:after {
  content: '';
  display: block;
  width: 35px;
  height: 35px;
  position: absolute;
  left: 50%;
  bottom: -65px;
  transform: translate(-50%, -50%);
  background: #333;
  border-radius: 50%;
}

/* The screen (or content) of the device */
.smartphone .content {
  width: 360px;
  height: 640px;
  background: white;
}
</style>



    @section("scripts")

    @show
  </body>
</html>
