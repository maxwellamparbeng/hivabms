@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Edit Company details</h2>
        

        <div class="container mt-4">



      

            <form id="paymentForm" method="POST" action=" {{ route('company.updatecompany', $user->companyId) }}" >
           
                @csrf
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                
               

                <input value="{{ $user->companyId }}" 
                        type="hidden" 
                        class="form-control" 
                        name="email" id="email"
                        placeholder="" required>



                    


                   <div class="mb-3">
                    <label for="title" class="form-label">Company name</label>
                    <input value="{{ $user->companyName }}" 
                        type="text" 
                        class="form-control" 
                        name="companyName" 
                        placeholder="" required>

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('companyName') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="description" class="form-label">Company description</label>
                    <textarea class="form-control" 
                        name="companyDescription" 
                        placeholder="What do you want solved ?" required>{{$user->companyDescription}}</textarea>

                    @if ($errors->has('Description'))
                        <span class="text-danger text-left">{{ $errors->first('companyDescription') }}</span>
                    @endif
                </div>



                
                <label for="description" class="form-label">Status</label>

                
                   <select class="form-control" name="Status" required>
                
                        <option value="{{ $user->status }}">Selected</option>
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>

                   </select>


                   <br>
                <div class="mb-3">
                    <label for="title" class="form-label">Email</label>
                    <input value="{{ $user->email }}" 
                        type="text" 
                        class="form-control" 
                        name="email" 
                        placeholder="" required>

                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Phone Number</label>
                    <input value="{{ $user->phoneNumber }}" 
                        type="text" 
                        class="form-control" 
                        name="phoneNumber" 
                        placeholder="" required>

                    @if ($errors->has('phoneNumber'))
                        <span class="text-danger text-left">{{ $errors->first('phoneNumber') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Sender Name</label>
                    <input value="{{ $user->senderName }}" 
                        type="text" 
                        class="form-control" 
                        name="senderName" 
                        placeholder="" required>

                    @if ($errors->has('senderName'))
                        <span class="text-danger text-left">{{ $errors->first('senderName') }}</span>
                    @endif
                </div>

                



                <div class="mb-3">
                    <label for="title" class="form-label">Sms Api Key</label>
                    <input value="{{ $user->smsApikey }}" 
                        type="text" 
                        class="form-control" 
                        name="smsApikey" 
                        placeholder="" required>
                    @if ($errors->has('smsApikey'))
                        <span class="text-danger text-left">{{ $errors->first('smsApikey') }}</span>
                    @endif
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Sms Api Email</label>
                    <input value="{{ $user->smsApiusername }}" 
                        type="text" 
                        class="form-control" 
                        name="smsApiusername" 
                        placeholder="" required>
                    @if ($errors->has('smsApiusername'))
                        <span class="text-danger text-left">{{ $errors->first('smsApiusername') }}</span>
                    @endif
                </div>


                
                <label for="description" class="form-label">Pricing</label>

                
<select class="form-control" name="ProductPricing" required>

     <option value="{{ $user->ProductPricing }}">Selected</option>
     <option value="Single">Single</option>
     <option value="Multiple">Multiple</option>

</select>



                <div class="mb-3">
                    <label for="title" class="form-label">Pos Barcode Scanner</label>
                    
                    <select class="form-control" name="posBarcodeScanner" required>

     <option value="{{ $user->posBarcodeScanner }}">Selected</option>
     <option value="yes">Yes</option>
     <option value="no">No</option>

              </select>
                    
                </div>



                <label for="description" class="form-label">Subscription</label>
               <select class="form-control" name="subscriptionTier" required>
               
               <?php
               $tiers=getPricingTiers();
               ?>

               <option value="{{ $user->subscriptionTierId }}">Selected</option>
               @foreach($tiers as $tier)
               <option value="{{ $tier->subscriptionTierId }}" >{{ $tier->subscriptionName }} - {{$tier->amount}}</option>
                @endforeach

                </select>
                <br>
               
                <div class="mb-3">
                    <label for="title" class="form-label">Tin</label>
                    <input value="{{ $user->tin }}" 
                        type="text" 
                        class="form-control" 
                        name="tin" 
                        placeholder="" required>
                    @if ($errors->has('tin'))
                        <span class="text-danger text-left">{{ $errors->first('tin') }}</span>
                    @endif
                </div>

                <br>





                </div>

                <br>
                <button type="submit"  class="btn btn-primary">Update</button>

                <a href="{{ route('company.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>



@endsection