@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Pending Transactions</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  
                  <th scope="col">Transaction Id</th>
                    <th scope="col">Payee Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Country</th>
                    <th scope="col">Currency </th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>

                  </tr>
                </thead>
                <tbody>
                    
                            <?php 
   
                               $encode= json_encode($pendingpayment);
                               $decode= json_decode($encode,true);
                               
                                             foreach ($decode as $res) {
                                               
                                            
                                              $id=$res['transactionId'];
                                              $payeeName=$res['payeeName'];
                                              $payeeEmail=$res['payeeEmail'];
                                              $amount=$res['amount'];
                                              $country=$res['countryName'];
                                      
                                              $currency=$res['currency'];
                                              $status=$res['status'];
                                            
                                              echo "<tr>";
                                              echo "<td scope='row' >".$id."</td>";
                                              echo "<td>".$payeeName."</td>";
                                              echo "<td>".$payeeEmail."</td>";
                                              echo "<td>".$amount."</td>";
                                              echo "<td>".$country."</td>";
                                              echo "<td>".$currency."</td>";
                                              echo "<td>".$status."</td>";
                                              echo "<td>";
                                              
                                              echo"<a href='$id/resolvepayment'>Resolve</a>";

                                              

                                              echo"</td>";



                                              
                                               echo "</tr>";
                                             }
                                         ?>

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



    <script src="https://js.paystack.co/v1/inline.js"></script>

<script>


function payWithPaystack2(e){

  alert('window closed');

}


const paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);

function payWithPaystack(e){
  e.preventDefault();
 
  
  //Ghana
  var pkeys="pk_test_40b9884419aad8ea63faf6ab96a20d23611bfc90";

  var amount = document.getElementById('amount').value * 100;
  var currency="GHS";
  var reference = document.getElementById('reference').value;
  var email = document.getElementById('email').value;
  var phone = document.getElementById('phone').value;

  //alert(email);

if(currency=="GHS"){
  var handler = PaystackPop.setup({
  key: pkeys,
  email: email,
  amount:amount,
  currency: "GHS",
  ref:reference,    //''+Math.floor((Math.random() * 1000000000) + 1),// generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
  metadata: {
     custom_fields: [
        {
            display_name: "Mobile Number",
            variable_name: "mobile_number",
            value: "0545444248"
        }
     ]
  },
  callback: function(response){

//    var response= response.reference   
let data = {reference:reference,email:email,amount:amount,_token:'{{csrf_token()}}'};
fetch("{{url('/processPayament') }}", {
method: "POST",
headers: {"Content-type": "application/json",
  'X-CSRF-TOKEN':'{{csrf_token()}}'

}, 
body: JSON.stringify(data)
}).then(res => {
console.log("Request complete! response:",res);
window.location.replace("{{url('/showbooking') }}");
//console.log("Request complete! responsegg:",JSON.stringify(data));
});

  },
  onClose: function(){
      alert('window closed');
  }
});


}




handler.openIframe();


}



</script>


@endsection