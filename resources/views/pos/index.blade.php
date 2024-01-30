@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
    
 

<section class="section">


<div class="row">
      
          <div class="col-md-9 ">



          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Create Sale</h5>


              <!-- Floating Labels Form -->
              <form name="" action="{{ route('pos.add') }}" method="POST" class="row g-3">

              @csrf
               <input type="hidden" id="_token" value="{{ csrf_token() }}">

                  <div class="col-md-5">
                  <div class="form-floating mb-3">
                   <select  name="product" class="form-select" id="js-example-basic-single" aria-label="State">
                   <option value="" >Please Choose product</option>
                   @foreach($products as $pro)
                  <option value="{{$pro->productId }}" >{{ $pro->name }} -(Qty {{ $pro->invQuantity }})</option>
                  @endforeach 
                  </select>
                   
                 </div>

                  </div>
                

                <?php 
                  
                  $pricing = getusercompanyposbarcodescannerinfo();
                  
                  ?>

           @if($pricing=="yes" )
                <div class="col-md-1">
                Barcode input
                </div>
                
                <div class="col-md-2">
               
                  <div class="form-floating mb-2">
                  
                  <input name="barcodeinput" autocomplete="off" type="text" autofocus class="form-control" id="floatingCity" placeholder="City">
                
                </div>
              
              
                </div>
                
                
            
                @endif
                
                <div class="col-md-1">
                Pricing
                
                </div>
                <?php 
                  
                  $pricing = getusercompanyproductpricinginfo();
                  
           
                  ?>

                <div class="col-md-2">
               
                  <div class="form-floating mb-3">
                  
                  <select name="pricing" class="form-select" id="js-example-basic-single" aria-label="State">


                 


        @if($pricing=="Multiple" )
           <option value="price" >Unit Price</option>
                  <option value="whprice" >Wholesale Price</option>
                  <option value="bwhprice" >Bulk Wholesale Price</option>
                  <option value="pbwhprice" >Promo Bulk Wholesale Price</option>
                  <option value="rprice" >Retail Price</option>
                  <option value="prprice" >Promotional Retail Price</option>
  
          @endif

          @if($pricing=="Single" )
           <option value="price" >Unit Price</option>
          @endif

                 
                   </select>
            
                  </div>
                </div>


                <div class="col-md-1">
                Quantity
               
                </div>


                <div class="col-md-2">
               
                  <div class="form-floating mb-3">
                   
                  <input name="quantity" type="text" class="form-control" id="floatingCity" placeholder="City">
                  </div>
                </div>

                



                <div class="col-md-2">
                  <div class="form-floating">
                  

                  <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                </div>
                
              </form>

            </div>
          </div>









          <div class="table-responsive card ">
              <table class="table datatable ">
                <thead>
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Id</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>

               
@foreach ($cart as $rec)
<tr>
@if (empty($rec->pic) )
                <th scope="row"><img height="50px" width="100px" src="/storage/dummy.jpg" alt="" title=""></th>
                 @else
                 <th scope="row"><img height="50px" width="100px" src="{{Storage::url($rec->pic)}}" alt="" title=""></th>
                @endif
    <th scope="row">{{ $rec->productId }}</th>
    <td>{{ $rec->name }}</td>
    <td>{{ $rec->cartQuantity }}</td>
    <td>{{ $rec->cartprice }}</td>
    <td><a href="" data-bs-toggle="modal" data-bs-target="#edit{{$rec->productId}}" class="btn btn-info">Edit </a>
    <a href="{{ route('pos.deletecart',$rec->cartId)}}" class="btn btn-primary">Delete</a>
   </td>
     
</tr>



<!-- Basic Modal -->

                
              </button>
              <div class="modal fade" id="edit{{$rec->productId}}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Update Quantity</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                 

                        <!-- Floating Labels Form -->
              <form name="" action="/updatequantity" method="POST" class="row ">
               
               @csrf
             <input type="hidden" id="_token" value="{{ csrf_token() }}">
             <input type="hidden" name="product" value="{{$rec->productId }}">
              <input type="hidden" name="cartId" value="{{$rec->cartId }}"> 
              
              <div class="col-md-5">
                Pricing
                
                </div>
                <?php 
                  
                  $pricing = getusercompanyproductpricinginfo();
                  
           
                  ?>

                <div class="col-md-10">
               
                  <div class="form-floating mb-3">
                  
                  <select name="pricing" class="form-select" id="js-example-basic-single" aria-label="State">


                 


        @if($pricing=="Multiple" )
           <option value="price" >Unit Price</option>
                  <option value="whprice" >Wholesale Price</option>
                  <option value="bwhprice" >Bulk Wholesale Price</option>
                  <option value="pbwhprice" >Promo Bulk Wholesale Price</option>
                  <option value="rprice" >Retail Price</option>
                  <option value="prprice" >Promotional Retail Price</option>
  
          @endif

          @if($pricing=="Single" )
           <option value="price" >Unit Price</option>
          @endif

                 
                   </select>
            
                  </div>
                </div>



                <div class="col-md-5">
                Quantity
                
                </div>

                 <div class="col-md-4">
                   <div class="form-floating mb-3">
                   <input name="quantity" type="text" value="{{ $rec->cartQuantity }}"  class="form-control" id="floatingCity" placeholder="City">
                   </div>
                 </div>
                 <div class="col-md-2">
                   <div class="form-floating">
                   <button type="submit" class="btn btn-primary">Update</button>
                   </div>
                 </div>
                 
               </form><!-- End floating Labels Form -->


                    </div>
                    <div class="modal-footer">
                 
                    </div>
                  </div>
                </div>
              </div><!-- End Basic Modal-->





@endforeach
                  
                   
<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
                          <td>&nbsp;</td>
													<td colspan="3">
														<p>
															
														</p>
														<h5 class="text-success"><strong>Grand Total:   <?php  echo $payroll = getCarttotal();
                            
                                
                          
                            ?></strong></h5>
													</td>			
												
												</tr>  
                
                 
                </tbody>
              </table>
              <!-- End Table with stripped rows -->


            
              


            </div>
        
        
        
        </div>





        <div class="col-lg-3">



<div class="card">
            <div class="card-body">
              <h5 class="card-title">Customer Information</h5>

              <!-- Floating Labels Form -->
              <form name="" action="{{ route('pos.createorder') }}" method="POST" class="row g-3">
              @csrf
             <input type="hidden" id="_token" value="{{ csrf_token() }}"> 
             
             <div class="col-md-12">
                  <div class="form-floating">
                    <input type="phone" name="phone" class="form-control" id="phone" onkeyup="searchclient()" placeholder="Your Email">
                    <label for="floatingEmail">Phone Number</label>
                  </div>
                </div>
              
              <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" name="name" class="form-control" id="fullname" placeholder="Your Name">
                    <label for="floatingName">Customer name</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Your Email">
                    <label for="floatingEmail">Email</label>
                  </div>
                </div>
                
                <div class="col-12">
                  <div class="form-floating">
                    <textarea name="address" class="form-control" placeholder="Address" id="address" style="height: 100px;"></textarea>
                    <label for="floatingTextarea">Address</label>
                  </div>
                </div>

               

                <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="payment" class="form-select" id="floatingSelect" aria-label="State">

                  <option value="cash" >Cash</option>
                  <option value="mobile money" >Mobile money</option>
                  <option value="bank Transfer" >Bank Transfer</option>
                  <option value="Cheque" >Cheque</option>
                  <option value="other" >Other</option>


                   </select>
                   <label for="floatingSelect">Payment method</label>
                 </div>

                  </div>
                </div>



                <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="paymentStatus" class="form-select" id="floatingSelect" aria-label="State">
                   
                   <option value="paid" >Paid</option>
                  <option value="unpaid" >Unpaid</option>
                 
                   </select>
                   <label for="floatingSelect">Payment Status</label>
                 </div>

                  </div>
                </div>


                <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="discount" class="form-select" id="floatingSelect" aria-label="State">
                   <option value="0" >0</option>
                   <option value="1" >1%</option>
                   <option value="2" >2%</option>
                   <option value="3" >3%</option>
                   <option value="4" >4%</option>
                   <option value="5" >5%</option>
                   <option value="6" >6%</option>
                   <option value="7" >7%</option>
                   <option value="8" >8%</option>
                   <option value="9" >9%</option>
                   <option value="10" >10%</option>
                
                   </select>
                   <label for="floatingSelect">Discount</label>
                 </div>

                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-floating mb-3">
                   <select name="vat" class="form-select" id="floatingSelect" aria-label="State">
                   <option value="no">no</option>
                   <option value="yes">yes</option>
                   </select>
                   <label for="floatingSelect">VAT</label>
                 </div>

                  </div>
                </div>
                
              
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Place Order</button>
                 
                </div>
              </form><!-- End floating Labels Form -->

            </div>
          </div>



          </div>





          </div>


    </section>





   
    </div>

@endsection













