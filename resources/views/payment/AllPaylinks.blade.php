@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">All Payment links</h5>
    



              @if(auth()->user()->can('hivapay.createpaymentlink') )
   
   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createpayrolls">Create payment link</button>
   
        @endif
 
 <br>
 <br> 

              <div class="modal fade" id="createpayrolls" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Account </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


          <form method="POST" action=" {{ route('hivapay.createpaymentlink') }}"  >
           
           @csrf
       <input type="hidden" id="_token" value="{{ csrf_token() }}">
         
    
           <div class="mb-3">
               <label for="title" class="form-label">Amount</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="amount" 
                   placeholder="" >

               @if ($errors->has('amount'))
                   <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
               @endif
           </div>

              <div class="mb-3">
               <label for="title" class="form-label">Description</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="description" 
                   placeholder="" >

               @if ($errors->has('description'))
                   <span class="text-danger text-left">{{ $errors->first('description') }}</span>
               @endif
           </div>


           <div class="mb-3">
               <label for="title" class="form-label">Pin</label>
               <input value="" 
                   type="text" 
                   class="form-control" 
                   name="pin" 
                   placeholder="" >

               @if ($errors->has('pin'))
                   <span class="text-danger text-left">{{ $errors->first('pin') }}</span>
               @endif
           </div>



           </div>

           <br>
           <button type="submit"  class="btn btn-primary">Create</button>
          
         
       </form>
                    </div>

                    </div>

                  </div>











              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  
                  <th scope="col">Payment Id</th>
                    <th scope="col">Description</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Country</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                    
                            <?php 
   
                               $encode= json_encode($paylinks);
                               $decode= json_decode($encode,true);
                               
                                             foreach ($decode as $res) {
                                              $userId=$res['userId'];
                                              $description=$res['description'];
                                              $amount=$res['amount'];
                                              $country=$res['countryName'];
                                              $status=$res['status'];
                                              $paymentId=$res['paymentLinkId'];
                                              $currency=$res['currency'];
                                              $created_at=$res['created_at'];
                                            
                                              echo "<tr>";
                                              echo "<td scope='row' >"; //.$paymentId.
                                              
                                              echo'<a href="'.paymentLinkUrl().'?id='.$paymentId.'  ">'.$paymentId.'</a>';
                                              
                                              echo"</td>";
            
                                              echo "<td>".$description."</td>";
                                              echo "<td>".$amount."</td>";
                                              echo "<td>".$country."</td>";
                                              echo "<td>".$currency."</td>";
                                              echo "<td>".$created_at."</td>";
                                               
                                              echo "<td>";
                                              
                                              echo' <div class="dropdown">
                                              <button class="btn bg-gradient-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="'.$paymentId.'/paymentsbylink">Payments</a></li>
                                                <li><a class="dropdown-item" href="'.paymentLinkUrl().'?id='.$paymentId.'">Receive Payment</a></li>
                                              
                                              </ul>
                                            </div>';
        
                                              
                                              echo "</td>";

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