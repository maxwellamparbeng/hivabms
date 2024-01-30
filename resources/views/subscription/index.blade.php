@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
       
        <div class="lead">
            Add new company
        </div>

        <div class="container mt-4">


            <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Company name</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="companyName" 
                        placeholder="" required>

                    @if ($errors->has('companyName'))
                        <span class="text-danger text-left">{{ $errors->first('companyName') }}</span>
                    @endif
                </div>


                <div class="col-md-6">
                    <input type="file" name="pic" class="form-control">
                
                    @if ($errors->has('image'))
                        <span class="text-danger text-left">{{ $errors->first('image') }}</span>
                    @endif

                </div>



                <div class="mb-3">
                    <label for="description" class="form-label">Company description</label>
                    <textarea class="form-control" 
                        name="Description" 
                        placeholder="Brief description" required></textarea>

                    @if ($errors->has('Description'))
                        <span class="text-danger text-left">{{ $errors->first('Description') }}</span>
                    @endif
                </div>


             


                <div class="mb-3">
                    <label for="title" class="form-label">Email</label>
                    <input value="" 
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
                    <input value="" 
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
                    <input value="" 
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
                    <input value="" 
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
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="smsApiusername" 
                        placeholder="" required>
                    @if ($errors->has('smsApiusername'))
                        <span class="text-danger text-left">{{ $errors->first('smsApiusername') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Sms Api Email</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="smsApiusername" 
                        placeholder="" required>
                    @if ($errors->has('smsApiusername'))
                        <span class="text-danger text-left">{{ $errors->first('smsApiusername') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Nature Of Business</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="natureOfBusiness" 
                        placeholder="" required>
                    @if ($errors->has('natureOfBusiness'))
                        <span class="text-danger text-left">{{ $errors->first('natureOfBusiness') }}</span>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Stock Reduction</label>
                
                        <select class="form-control" name="stockReduction" required>

                 <option value="yes">Yes</option>
                   <option value="no">No</option>

                         </select>



                    @if ($errors->has('stockReduction'))
                        <span class="text-danger text-left">{{ $errors->first('stockReduction') }}</span>
                    @endif
                </div>


                <label for="description" class="form-label">Pricing</label>

                
                  <select class="form-control" name="ProductPricing" required>

    
              <option value="Single">Single</option>
               <option value="Multiple">Multiple</option>

                </select>


            

                <div class="mb-3">
                    <label for="title" class="form-label">Pos Barcode Scanner</label>
                    
                    <select class="form-control" name="posBarcodeScanner" required>

                <option value="yes">Yes</option>
              <option value="no">No</option>

              </select>
                    
                </div>


                <label for="description" class="form-label">Subscription</label>
               <select class="form-control" name="subscriptionTier" required>
               
               <?php
               $tiers=getPricingTiers();
               ?>

               @foreach($tiers as $tier)
               <option value="{{ $tier->subscriptionTierId }}" >{{ $tier->subscriptionName }} - {{$tier->amount}}</option>
                @endforeach

                </select>
                <br>
               
                <div class="mb-3">
                    <label for="title" class="form-label">Tin</label>
                    <input value="" 
                        type="text" 
                        class="form-control" 
                        name="tin" 
                        placeholder="" required>
                    @if ($errors->has('tin'))
                        <span class="text-danger text-left">{{ $errors->first('tin') }}</span>
                    @endif
                </div>

                <br>

                <button type="submit" class="btn btn-primary">Add company</button>
                <a href="{{ route('company.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection