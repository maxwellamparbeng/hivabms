@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

         <div class="">
            <div class="">
           
            <br>
            <br>
              
        
              <div class="row">
        

              <div class="col-md-2">

             </div>




<div class="col-md-6">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Verify Transfer Details</h5>

              <div class="container mt-4">


<form method="POST" action="{{ route('hivapay.finalizefundtransfer') }}" >
    @csrf

    <div class="mb-3">
    <div class="form-group">
        Name of Recipient
        <input readonly required type="text" name="amount" value="{{ session('recipientfullname') }}" class="form-control" id="exampleFormControlInput1" placeholder="0000">
      </div>

      </div>

      <div class="mb-3">
      <div class="form-group">
        Channel
        <select required class="form-control" name="network">
        <option value="{{ session('network') }}">{{ session('network') }}</option>
        </select>
      </div>
      </div>

    <div class="mb-3">
        <label for="title" class="form-label">Amount</label>
        <input value="{{ session('amount') }}" 
            type="text" 
            class="form-control" 
            name="amount" 
            placeholder="" readonly>

        @if ($errors->has('amount'))
            <span class="text-danger text-left">{{ $errors->first('amount') }}</span>
        @endif
    </div>

    <div class="mb-3">
    <div class="form-group">
        Account Number
        <input readonly required type="text" name="mobileMoneyNumber" value="{{ session('mobileMoneyNumber') }}" class="form-control" id="exampleFormControlInput1" placeholder="XXXXXXXXXX">
      </div>
      </div>

    <div class="mb-3">
    <div class="form-group">
        Pin 
        <input  type="text" required name="pin" value="" class="form-control" id="exampleFormControlInput1" placeholder="****">
      </div>
      </div>
      
    <button type="submit" class="btn btn-primary">Transfer</button>

</form>
</div>

            </div>
          </div>

</div>





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