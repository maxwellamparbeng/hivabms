@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
      
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Transactions</h5>
              
             

              <!-- Table with stripped rows -->

              <div class="table-responsive">
              <table class="table datatable ">
                <thead>
                  <tr>
                  
                  <th scope="col">Transaction Id</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Phone number</th>
                    
                    <th scope="col">Total Amount</th>
                    <th scope="col">Payment method</th>
                    <th scope="col">Address</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Action</th>
                   
                   
                  </tr>
                </thead>
                <tbody>

               
               
                @foreach ($details as $rec)
<tr>
    <th scope="row">{{ $rec->transactionId }}</th>
    <td>{{ $rec->customer }}</td>
    <td>{{ $rec->email }}</td>
    <td>{{ $rec->phone }}</td>
    <td>{{ $rec->totalAmount }}</td>
    <td>{{ $rec->paymentMethod}}</td>
    <td>{{ $rec->address}}</td>
    <td>{{ $rec->created_at}}</td>
  
    @if(auth()->user()->can('pos.viewtransactiondetails') )
  
    <td><a href="{{route('pos.viewtransactiondetails',$rec->transactionId)}}" class="btn btn-primary">View all</a> 
    @endif
  <br>
</br>
@if(auth()->user()->can('pos.viewreceipt') )
  <a href="{{ route('pos.viewreceipt',$rec->transactionId)}}" class="btn btn-primary">View Receipt</a>
  @endif
</td>


             </tr>
@endforeach

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