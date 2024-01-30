@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Transactions</h5>
              
              <p>

              @if(auth()->user()->can('hivapay.pendingtransactions') )
    <a href="{{ route('hivapay.pendingtransactions') }}" class="btn btn-info">Pending Transactions</a> 
  
       @endif
        

       <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Search for transaction
  </a>

       
       </p>

       <br>
       <br>




       <div class="collapse" id="collapseExample">
  <div class="card card-body">
  <form action="{{ route('hivapay.searchhptransactions') }}" method="POST">
  <div class="row">
    <div class="col-md-4">
      
      <div class="form-group">
        Transaction Id
        <input required type="text" name="id" value="" class="form-control" id="exampleFormControlInput1" placeholder="0000">
      </div>

  

     

      <div class="form-group">
      <div class="modal-footer">
        <button type="submit" class="btn bg-gradient-primary">Search</button>
        <button type="button" class="btn bg-gradient-secondary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Close</button>
       
      </div>

      </div>

    </div>


  </div>

  
</form>
  </div>
</div>

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  
                  <th scope="col">Transaction Id</th>
                    <th scope="col">Sender Id</th>
                    <th scope="col">Sender Username</th>
                    <th scope="col">Sender Account</th>
                    
                    <th scope="col">Receiver Id</th>
                    <th scope="col">Receiver Username</th>
                    <th scope="col">Receiver Account</th>
                    <th scope="col">Currency </th>
                    <th scope="col">Amount</th>
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Transaction status</th>
                    <th scope="col">Date</th>

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
                                              $name=$res['transactionName'];
                                              $statusname=$res['statusName'];
                                              $currency=$res['currency'];
                                            
                                            
                                              echo "<tr>";
                                              echo "<td scope='row' >".$id."</td>";
                                              echo "<td>".$senderUserId."</td>";
                                              echo "<td>".$senderUsername."</td>";
                                              echo "<td>".$senderPhoneNumber."</td>";
                                              echo "<td>".$receiverUserId."</td>";
                                              echo "<td>".$receiverUsername."</td>";
                                              echo "<td>".$receiverPhoneNumber."</td>";
                                              echo "<td>".$currency."</td>";
                                              echo "<td>".$amount."</td>";
                                              echo "<td>".$name."</td>";
                                              echo "<td>".$statusname."</td>";
                                              echo "<td>". $dateCreated."</td>";

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