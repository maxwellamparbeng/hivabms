<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hiva Bms</title>
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

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
  
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>


  <!-- Template Main CSS File -->
  <link href="{!! url('assets/css/style.css') !!}" rel="stylesheet">



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

 <script type = "text/javascript">
         google.charts.load('current', {packages: ['corechart']});     
      </script>
      
       <script type = "text/javascript">
         google.charts.load('current', {packages: ['corechart','line']});  
      </script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
     
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> 






  <script type="text/javascript">

function searchclient(){

let search = document.getElementById("phone").value;
let $data={searchdata:search}
let url ="http://127.0.0.1:8000/api/clientinfo";



if(search.length==0){

document.getElementById("fullname").value = "";
document.getElementById("email").value = "";
document.getElementById("address").value = "";

}

if(search.length==10){
// Make a GET request
fetch(url,{
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
      'Accept': 'application/json',
		},
    body: JSON.stringify({"searchdata":search})
    //body: JSON.stringify(search),
	})
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {

    if(data["Status"]==200){
      console.log(data);
    console.log(data["fullname"]);
    console.log(data["address"]);
    console.log(data["phone"]);
    console.log(data["email"]);

    let name =data["fullname"];
    let email =data["email"];
    let address =data["address"];
    let phone =data["phone"];

    document.getElementById("fullname").value = name;
    document.getElementById("email").value = email;
    document.getElementById("address").value = address;
    //document.getElementById("phone").value = address;
    }

    else{

      document.getElementById("fullname").value = "";
    document.getElementById("email").value = "";
    document.getElementById("address").value = "";
    
    }
 

  })
  .catch(error => {
    console.error('Error:', error);
  });

}

}
// $(document).ready(function() {
//     var search = $("#phone");
//     $data={searchdata:search}
//     var url ="http://127.0.0.1:8000/clientinfo";
//         search.keyup(function() {
//             if (search.val() != '') { 
//               //alert('HELLO EVERYONE');
              
//             $.get(url,{ search : search.val()}, function(data) {
//                 //$(".result").html(data);
//                 //alert(data);
//                 // alert('HELLO EVERYONE');
//                 //alert(data); 

//                 var response=JSON.parse(data)
                
//                 console.log(response);
//             });
//             }
//         });

// });










$(document).ready(function() {
    $("#js-example-basic-single").select2();
    $("#js-example-basic-single2").select2();
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );


});


     function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Report.' + (type || 'xlsx')));
    }


function copytoclipboard() {
  // Get the text field
  var copyText = document.getElementById("myInput").value;

  // // Select the text field
  // copyText.select();
  // copyText.setSelectionRange(0, 99999); // For mobile devices

  // // Copy the text inside the text field
  // navigator.clipboard.writeText(copyText.value);
  
  // Alert the copied text
  alert("Copied the text: " + copyText);
} 


</script>



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


@import url(https://fonts.googleapis.com/css?family=Roboto:400,100,900);

html,
body {
  -moz-box-sizing: border-box;
       box-sizing: border-box;
  height: 100%;
  width: 100%; 
  background: #FFF;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
}
 
.wrapper {
  display: table;
  height: 100%;
  width: 100%;
}

.container-fostrap {
  display: table-cell;
  padding: 1em;
  text-align: center;
  vertical-align: middle;
}
.fostrap-logo {
  width: 100px;
  margin-bottom:15px
}
h1.heading {
  color: #fff;
  font-size: 1.15em;
  font-weight: 900;
  margin: 0 0 0.5em;
  color: #505050;
}
@media (min-width: 450px) {
  h1.heading {
    font-size: 3.55em;
  }
}
@media (min-width: 760px) {
  h1.heading {
    font-size: 3.05em;
  }
}
@media (min-width: 900px) {
  h1.heading {
    font-size: 3.25em;
    margin: 0 0 0.3em;
  }
} 
.card {
  display: block; 
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12); 
    transition: box-shadow .25s; 
}
.card:hover {
  box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
}
.img-card {
  width: 100%;
  height:200px;
  border-top-left-radius:2px;
  border-top-right-radius:2px;
  display:block;
    overflow: hidden;
}
.img-card img{
  width: 100%;
  height: 200px;
  object-fit:cover; 
  transition: all .25s ease;
} 
.card-content {
  padding:15px;
  text-align:left;
}
.card-title {
  margin-top:0px;
  font-weight: 700;
  font-size: 1.65em;
}
.card-title a {
  color: #000;
  text-decoration: none !important;
}
.card-read-more {
  border-top: 1px solid #D4D4D4;
}
.card-read-more a {
  text-decoration: none !important;
  padding:10px;
  font-weight:600;
  text-transform: uppercase
}







</style>






  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    @include('sweet::alert') 
    @include('layouts.partials.navbar')

     <main id="main" class="main">
     
     @yield('content')

    </main>


    




     <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Hiva Solutions</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://hivasolutions.com/">HIVA</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>




  <!-- Vendor JS Files -->
 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
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


    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    

    @section("scripts")

    @show
  </body>
</html>
