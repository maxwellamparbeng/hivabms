@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
      

        




        <div class="row">

        <div class="col-md-6">

        <div class="card container">

        <h1>Compose Your Message</h1>
        <hr>

<form id="contact" name="contact" method="POST" action="{{route('company.executesms') }}">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Sender Name</label>
        <input readonly value="{{ $user->senderName }}" 
            type="text" 
            class="form-control" 
            name="senderName" 
            placeholder="" required>
        @if ($errors->has('senderName'))
            <span class="text-danger text-left">{{ $errors->first('senderName') }}</span>
        @endif
    </div>

   

 <label for="description" class="form-label">Campaign Type</label>

<select id="campaign_type" class="form-control" name="campaign_type" required>

     <option value="Personalized">Personalized</option>
     <option value="Customers">All Customers</option>

       @foreach ($contactgroups as $rec) 

<option value="{{ $rec->contactGroupId }}"> {{ $rec->name }}

</option>
@endforeach 

     @if(auth()->user()->can('hr.allEmployees') )
   
     <option value="Employees">All Employees</option>
                        @endif
     

</select>


<br>


<div class="mb-3">
        <label for="description" id="mobile_numbers_label" class="form-label">List of contacts</label>
        <textarea id="mobile_numbers" rows=14 class="form-control quill-editor-default" 
            name="mobile_numbers" 
            placeholder="Each contact should be on a new line" ></textarea>

        @if ($errors->has('mobile_numbers'))
            <span class="text-danger text-left">{{ $errors->first('mobile_numbers') }}</span>
        @endif
    </div>

    


    <div class="mb-3">
        <label for="description" class="form-label">Text message</label>
        <textarea rows=14 class="text_message form-control quill-editor-default" 
            name="message" id="text_message" 
            placeholder="What message do you want to send ?" required></textarea>

        @if ($errors->has('message'))
            <span class="text-danger text-left">{{ $errors->first('message') }}</span>
        @endif
    </div>



    <div class="mb-3">
       
        <input value="{{ $user->smsApikey }}" 
            type="hidden" 
            class="form-control" 
            name="smsApikey" 
            placeholder="" required>
        @if ($errors->has('smsApikey'))
            <span class="text-danger text-left">{{ $errors->first('smsApikey') }}</span>
        @endif
    </div>



    <div class="mb-3">
        
        <input value="{{ $user->smsApiusername}}" 
            type="hidden" 
            class="form-control" 
            name="smsApiusername" 
            placeholder="" required>
        @if ($errors->has('smsApiusername'))
            <span class="text-danger text-left">{{ $errors->first('smsApiusername') }}</span>
        @endif
    </div>




    <button type="submit" class="btn btn-primary">Send Sms</button>
    <a href="" class="btn btn-default">Back</a>

    <br>
    <br>
    <br>
    
</form>
</div>






        
        </div>









        <div class="col-md-6">

<div class="card  ">



    <div class="container-fluid">
  
           <p>A text page consist of 160 characters</p>
           

      <div id="smscount"></div>
          <hr>
  <p><b>Calculation is done by multiplying the number of pages of the SMS by the total quantity of recipients</b></p>
<div class="card-body  ">

  <div class="smartphone">
  <div class="contents">



 <p>Text Message</p>

  <div class="output">


  </div>

  <p> <h6>Words: <span id="count">0</span></h6>
      <h6>Characters: <span id="chars">0</span></h6> </p>
  </div>



</div>

</div>


</div>

</div>

</div>














       </div>





        










    </div>



    <script type="text/javascript">
$(document).ready(function(){
    $("#text_message").keyup(function(){
        // Getting the current value of textarea
        var currentText = $(this).val();

        // Setting the Div content
        $(".output").text(currentText);
    });
});
</script>


<script>
    $(document).ready(function() {
   
        $('#contact select[name="campaign_type"]').change(function () {
            if ($('#contact select[name="campaign_type"] option:selected').val() == 'Employees') {

                  $('#mobile_numbers').hide();
                    $('#mobile_numbers_label').hide();
                   

            }


            if ($('#contact select[name="campaign_type"] option:selected').val() == 'Customers') {

$('#mobile_numbers').hide();
  $('#mobile_numbers_label').hide();
 

}


            if ($('#contact select[name="campaign_type"] option:selected').val() == 'Personalized') {
                 $('#mobile_numbers').show();
                    $('#mobile_numbers_label').show();

            }


            if ($('#contact select[name="campaign_type"] option:selected').val() != 'Customers' || ('#contact select[name="campaign_type"] option:selected').val() != 'Employees' ) {
                 $('#mobile_numbers').hide();
                    $('#mobile_numbers_label').hide();

            }



            
        
        });








} );

</script>


<script >
function CountLeft(field, count, max) {
if (field.value.length > max)
field.value = field.value.substring(0, max);
else
count.value = max - field.value.length;
}

function count() {
	var text = document.getElementById("text_message").value;
    var wordCount, countChars;
    var messagecounter;

	if(text == ""){
		wordCount = 0;
        countChars = 0;
        messagecounter=0;

	}else{
		var regex = /\s+/gi;
		wordCount = text.trim().replace(regex, ' ').split(' ').length;
        countChars = text.length;



	}


	document.getElementById("count").innerHTML = wordCount;
    document.getElementById("chars").innerHTML = countChars;
    document.getElementById("messagecounter").innerHTML = countChars;
}

</script>


@endsection