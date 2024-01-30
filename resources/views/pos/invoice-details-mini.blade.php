<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Receipt example</title>

        <style>

* {
    font-size: 12px;
    font-family: 'Times New Roman';
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 75px;
    max-width: 75px;
}

td.quantity,
th.quantity {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

td.price,
th.price {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
          </style>





    </head>
    <body>
        <div class="ticket">

            @foreach ($company as $rec)

<img height="20px" width="100px" src="{{Storage::url($rec->logo)}}" alt="Logo" title="">


<p class="centered">
{{$rec->companyName}}
<br>
{{ $rec->companyDescription }}
<br>
{{ $rec->phoneNumber }}
<br>
{{ $rec->email }}

</p>
@endforeach





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
            
            
          
           
                <table>
                <thead>
                    <tr>
                        <th class="description">Item</th>
                        <th class="quantity">Qty</th>
                        <th class="price">Price</th>
                        <th class="price">Sub Total</th>


                    </tr>
                </thead>
                <tbody>
                @foreach ($cartdata as $rec)
                    <tr>
                         <td class="description">{{ $rec->name }}</td>
                        <td class="quantity">{{ $rec->detailsQuantity }}</td>
                        <td class="price">{{ $rec->price }}</td>
                        <td class="price">{{ $rec->price * $rec->detailsQuantity }}</td>



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



                </tbody>
            </table>
            <p class="centered">{{ $customers['note'] }}
                </p>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
      

        <script>
const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});

</script>
    </body>
</html>