@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Payment page</h2>
        

        <div class="container mt-4">




      

            <form id="paymentForm">
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
                <div class="mb-3">
                    <label for="title" class="form-label">Email</label>
                    <input value="@if(session()->has('email')){{ session()->get('email') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="email" id="email"
                        placeholder="" required>

                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Phone Number</label>
                    <input value="@if(session()->has('email')){{ session()->get('phoneNumber') }}
   @else   
   @endif" 
                        type="text" 
                        class="form-control" 
                        name="phoneNumber"  id="phone"
                        placeholder="" required>

                    @if ($errors->has('phoneNumber'))
                        <span class="text-danger text-left">{{ $errors->first('phoneNumber') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Amount To pay</label>
                    <input value="190" 
                        type="text" 
                        class="form-control" 
                        name="amount"  id="amount"
                        placeholder="" required>

                    @if ($errors->has('phoneNumber'))
                        <span class="text-danger text-left">{{ $errors->first('phoneNumber') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Reference</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="reference"  id="reference"
                        placeholder="" required value="<?php echo $randomNumber = rand(); ?>">

                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>


                <button type="submit" onclick="payWithPaystack()" class="btn btn-primary">Pay</button>

                <a href="{{ route('booking.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

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