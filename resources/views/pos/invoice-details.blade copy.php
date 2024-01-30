
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
<div class="card-body">
<div id="invoice">
<div class="toolbar hidden-print">
<div class="text-end">

<a href="javascript:;" onclick="window.print()"  class="btn btn-secondary">
											<i class="icon-printer"></i> Print
										</a>
<hr>
</div>
<div class="invoice overflow-auto">
<div style="min-width: 600px">
<header>
<div class="row">
<div class="col">
<a href="javascript:;">
<img src="assets/images/logo-icon.png" width="80" alt="">


@foreach ($company as $rec)

<img height="50px" width="200px" src="{{Storage::url($rec->logo)}}" alt="" title="">

@endforeach
  


</a>
</div>
<div class="col company-details">
<h2 class="name">






   @foreach ($company as $rec)

<a target="_blank" href="javascript:;">
{{$rec->companyName}}
</a>
</h2>
<div>{{ $rec->companyDescription }}</div>
<div>{{ $rec->phoneNumber }}</div>
<div>{{ $rec->email }}</div>

@endforeach


</div>
</div>
</header>
<main>
<div class="row contacts">
<div class="col invoice-to">
<div class="text-gray-light">INVOICE TO:</div>

@foreach ($cartdata as $rec)

<?php   $customers = viewposinvoicedetails($rec->transactionId);
   
   // print_r(
   //    $customers
   // );
      	
?>
@endforeach






   <h2 class="to">{{ $customers['customer'] }}</h2>
<div class="address">{{ $customers['address'] }}</div>
<div class="email">{{ $customers['email'] }}</a>
</div>
</div>
<div class="col invoice-details">
<h1 class="invoice-id">Receipt</h1>
<p>{{ $customers['invoiceId'] }}</p>
<div class="date">Date of Invoice:{{ $customers['created_at'] }} </div>






</div>
</div>
<table>
<thead>
<tr>
<th class="text-left">#</th>
<th class="text-left">Name</th>
<th class="text-right">Quantity</th>
<th class="text-right">Price</th>
<th class="text-right">TOTAL</th>
</tr>
</thead>
<tbody>

@foreach ($cartdata as $rec)


<tr>
<td class="no">{{  $loop->iteration }}</td>
    <td class="text-left">{{ $rec->name }}</td>
    <td class="qty">{{ $rec->detailsQuantity }}</td>
    <td class="unit">{{ $rec->price }}</td>

    <td class="total">{{ $rec->price * $rec->detailsQuantity }}</td>
    </tr>
@endforeach


</tbody>
<tfoot>
<tr>
<td colspan="2"></td>
<td colspan="2">SUBTOTAL</td>
<td>
@foreach ($cartdata as $rec)

<?php   $customers = viewposinvoicedetails($rec->transactionId);
   
   

   // print_r(
   //    $customers
   // );
      	
?>



@endforeach


{{ $customers['total'] }}

</td>
</tr>


<tr>
<td colspan="2"></td>
<td colspan="2">Discount -</td>
<td>

@foreach ($cartdata as $rec)

<?php   $customers = viewposinvoicedetails($rec->transactionId);
   
   // print_r(
   //    $customers
   // );
      	
?>
@endforeach

{{ $customers['discount'] }}
</td>
</tr>








<tr>
<td colspan="2"></td>
<td colspan="2">VAT TAX 21% +</td>
<td>

@foreach ($cartdata as $rec)

<?php   $customers = viewposinvoicedetails($rec->transactionId);
   
   // print_r(
   //    $customers
   // );
      	
?>
@endforeach

{{ $customers['vat'] }}
</td>
</tr>




<tr>
<td colspan="2"></td>
<td colspan="2">GRAND TOTAL</td>
<td>

@foreach ($cartdata as $rec)

<?php   $customers = viewposinvoicedetails($rec->transactionId);
   
   $vat =$customers['vat'];
   $total=$customers['total'];
   $discount=$customers['discount'];
  
  $total-$discount+$vat; 

 	
?>
@endforeach

{{ $customers['total']-$customers['discount']+$customers['vat'] }}

</td>
</tr>


</tfoot>
</table>
<br>
<br>
<br>
<br>

<div class="thanks">Thank you!</div>
<div class="notices">
<div>NOTICE:</div>
<div class="notice">
   
@foreach ($cartdata as $rec)

<?php   $customers = viewposinvoicedetails($rec->transactionId);
   


   // print_r(
   //    $customers
   // );
      	
?>



@endforeach

</div>
</div>
</main>
<footer></footer>
</div>

<div></div>
</div>
</div>
</div>
</div>
</div>
<style type="text/css">
body{margin-top:20px;
background-color: #f7f7ff;
}
#invoice {
    padding: 0px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #0d6efd
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #0d6efd
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #0d6efd;
    background: #e7f2ff;
    padding: 10px;
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,
.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #0d6efd;
    font-size: 1.2em
}

.invoice table .qty,
.invoice table .total,
.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #0d6efd
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #0d6efd;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0px solid rgba(0, 0, 0, 0);
    border-radius: .25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
}

.invoice table tfoot tr:last-child td {
    color: #0d6efd;
    font-size: 1.4em;
    border-top: 1px solid #0d6efd
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px !important;
        overflow: hidden !important
    }
    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }
    .invoice>div:last-child {
        page-break-before: always
    }
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #0d6efd;
    background: #e7f2ff;
    padding: 10px;
}
</style>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script type="text/javascript">

</script>
</body>
</html>