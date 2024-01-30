
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<title>Hiva Bms | Receipt</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
<div class="card">
<div id="invoice-POS">
<a href="javascript:;" onclick="window.print()"  class="btn btn-secondary">
											<i class="icon-printer"></i> Print
										</a>
    <center id="top">
    <div class="logo">

    

    </div>

      @foreach ($company as $rec)

<img height="20px" width="100px" src="{{Storage::url($rec->logo)}}" alt="" title="">

{{$rec->companyName}}
<p>
 
{{ $rec->companyDescription }}
{{ $rec->phoneNumber }}
{{ $rec->email }}

</p>
@endforeach

<hr>
      
      <div class="info"> 

      @foreach ($cartdata as $rec)

<?php   $customers = viewposinvoicedetails($rec->transactionId);	

$vat =$customers['vat'];
$total=$customers['total'];
$discount=$customers['discount'];

$total-$discount+$vat; 
?>
@endforeach

<p> 
            Receipt Id   : {{ $customers['invoiceId'] }} </br>
            Date Created : {{ $customers['created_at'] }}</br>
         
        </p>



      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        <h2>Customer Info</h2>
       
   

        <p> 
            Name   : {{ $customers['customer'] }}</br>
            Address : {{ $customers['address'] }}</br>
            Email   : {{ $customers['email'] }}</br>
            Phone   : {{ $customers['phone'] }}</br>
        </p>
      </div>
    </div><!--End Invoice Mid-->
    
    <div id="bot">

					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="item"><h2>Item</h2></td>
								<td class="Hours"><h2>Qty</h2></td>
								<td class="Rate"><h2>Price</h2></td>
                <td class="Rate"><h2>Sub Total</h2></td>
							</tr>
@foreach ($cartdata as $rec)
<tr class="service">
<td class="tableitem"><p class="itemtext">{{ $rec->name }}</p></td>
<td class="tableitem"><p class="itemtext">{{ $rec->detailsQuantity }}</p></td>
<td class="tableitem"><p class="itemtext">{{ $rec->price }}</p></td>

<td class="tableitem"><p class="itemtext">{{ $rec->price * $rec->detailsQuantity }}</p></td>
    </tr>
@endforeach

							<tr class="tabletitle">
                            <td></td>
								<td></td>
								<td class="Rate"><h2>Sub Total-</h2></td>
								<td class="payment"><h2>{{ $customers['subtotal'] }}</h2></td>
							</tr>


                        

							<tr class="tabletitle">
                            <td></td>
								<td></td>
								<td class="Rate"><h2>Vat</h2></td>
								<td class="payment"><h2>{{ $customers['vat'] }}</h2></td>
							</tr>


                            <tr class="tabletitle">
                            <td></td>
                            <td></td>
                            <td></td>
								<td class="payment">
								@foreach ($cartdata as $rec)

<?php   

$customers = viewposinvoicedetails($rec->transactionId);
  
 $json=$customers['vatDetails'];
   $obj = json_decode($json, TRUE);

   foreach($obj as $key => $value) 
   {
    unset($obj["Vat Percentage"]); 
    echo $key.' :'.$value.'<br>';
   }
      	
?>
@endforeach

</td>



							</tr>


                            <tr class="tabletitle">
                            <td></td>
								<td></td>
								<td class="Rate"><h2>Discount-</h2></td>
								<td class="payment"><h2>{{ $customers['discount'] }}</h2></td>
							</tr>


                            <tr class="tabletitle">
                            <td></td>
								<td></td>
								<td class="Rate"><h2>Grand total</h2></td>
								<td class="payment"><h1>{{ $customers['total']-$customers['discount']+$customers['vat'] }}</h1></td>
							</tr>


                            


                            
						</table>
					</div><!--End Table-->

					<div id="legalcopy">
						<p class="legal"><strong>{{ $customers['note'] }}</strong>  
						</p>
					</div>

				</div><!--End InvoiceBot-->
  </div><!--End Invoice-->

</div>
<style type="text/css">

#invoice-POS{
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding:2mm;
  margin: 0 auto;
  width: 44mm;
  background: #FFF;
  
} 
::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
}
 
#top, #mid,#bot{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}

#top{min-height: 100px;}
#mid{min-height: 80px;} 
#bot{ min-height: 50px;}

#top .logo{
  //float: left;
	height: 60px;
	width: 60px;
	
	background-size: 60px 60px;
}
.clientlogo{
  float: left;
	height: 60px;
	width: 60px;
	
	background-size: 60px 60px;
  border-radius: 50px;
}
.info{
  display: block;
  #float:left;
  margin-left: 0;
}
.title{
  float: right;
}
.title p{text-align: right;} 
table{
  width: 100%;
  border-collapse: collapse;
}
td{
  //padding: 5px 0 5px 15px;
  //border: 1px solid #EEE
}
.tabletitle{
  //padding: 5px;
  font-size: .5em;
  background: #EEE;
}
.service{border-bottom: 1px solid #EEE;}
.item{width: 24mm;}
.itemtext{font-size: .5em;}

#legalcopy{
  margin-top: 5mm;
}

  
  
}

</style>

</script>
</body>
</html>