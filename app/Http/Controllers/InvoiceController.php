<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\CampaignReport;
use App\Models\InvoiceNote;
use Illuminate\Support\Facades\DB;
use SweetAlert;
use App\Models\Invoice;
use App\Models\InvoiceCart;
use App\Models\InvoiceDetails;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use \Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Branch;
class InvoiceController extends Controller
{

    public function invoice() 
    {
    $branchId=getuserbranchId();    
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    //$cart =DB::table('invoicecart')->join('products','products.productId', '=', 'invoicecart.productId')->where('invoicecart.userId',$userInfo)->get();
    $sql="select *,invoicecart.price as cartprice from invoicecart inner join products ON products.productId=invoicecart.productId where invoicecart.userId='$userInfo' " ;
    $cart =  DB::select(DB::raw($sql));
    $products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->join('inventory', 'inventory.productId', '=', 'products.productId')->where('products.companyId',$companyId)->where('inventory.branchId',$branchId)->get();  
    return view('invoice.index',compact('products','cart'));   

    }


    public function manageinvoicenote() 
    {
    $branchId=getuserbranchId();    
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $note=DB::table('invoicenote')->where('invoicenote.companyId',$companyId)->get();
    return view('invoice.invoicenote.index',compact('note'));   

    }


    public function addinvoicenote(Request $request)
    {
    return view('invoice.invoicenote.add');   
    }


    public function storenote(Request $request)
    {
        $validatedData = $request->validate([
            'note' => 'required',  
        ]);
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;
        $sql="SELECT * FROM `invoicenote` where companyId='$companyId' ";
        $details =DB::select(DB::raw($sql));
        if(count($details)>0){
        alert()->error('More than one Invoice Note cannot be added', 'Warning!');
        return redirect('/manageinvoicenote');
        }
        else{
            $mytime = Carbon::now();
            $uuid = Idgenerator();//Str::uuid()->toString();
            $cart = new InvoiceNote();
            $cart->noteId = $uuid;
            $cart->note = request('note');
            $cart->companyId = getusercompanyId();
            $cart->save();
            alert()->success('Invoice Note Added succesfully', 'Success!');
            return redirect('/manageinvoicenote');
        }
     }



    public function editinvoicenote(InvoiceNote $noteId)
    {

        //$category = Branch::where('branchId', $branchId)->get();
        return view('invoice.invoicenote.edit', [
            'user' => $noteId,
          
        ]);

    
    }

    

    public function updateinvoicenote(Request $request)
    {

        $validatedData = $request->validate([
            'note' => 'required',
            'noteId' => 'required',    
        ]);
        
        $mytime = Carbon::now();
        $uuid = Idgenerator();//Str::uuid()->toString();
        $cart = InvoiceNote::find(request('noteId'));
        $cart->noteId =request('noteId');
        $cart->note = request('note');
        $cart->save();
        alert()->success('Invoice Note Updated succesfully', 'Success!');
        return redirect('/manageinvoicenote'); 

    
    }


    public function addinvoice(Request $request)
    {

        $validatedData = $request->validate([
            'product' => 'required',
            'quantity' => 'nullable',
            'pricing' => 'required',
            'barcodeinput'=>'nullable'
            
        ]);




        if(empty(request('barcodeinput')) && empty(request('product'))  ){
            alert()->error('Barcode or product cannot be empty', 'Error!');
            return redirect('/pos'); 
        }

        $branchId=getuserbranchId(); 
        $productId=0;
        $qty=0;


        $feature="invoice";
        $data=getCompanySubcriptionDetails($feature);
        if(empty($data)){

        }
      elseif(!$data[0]){   
             alert()->error($data[1], 'Error!');
             return redirect($data[2]);
        }


        
        if(empty(request('quantity'))){
            $qty=1;
        }

        else{

           $qty=request('quantity');
           
            if(!is_numeric($qty)){
                alert()->error('Quantity must be a number', 'Error!');
                return redirect('/pos'); 
    
            }
             
        }
       
      
        if(!empty(request('barcodeinput'))){

            $barcodeid=getbarcodeId(request('barcodeinput'));
            
            if($barcodeid!='no data'){
    
             $productId=$barcodeid;
        
        
           }

           else{

            alert()->error('Product not found. Please scan once again', 'Error!');
            return redirect('/pos'); 

           }

        
      
      
        }

        else{

            $productId=request('product');

        }


        $pquantity = InvoiceCart::where('productId',$productId)->where('userId', Auth::user()->id)->get();
        
         $count=count($pquantity);

       
        if($count==1){
            alert()->error('Product already in cart', 'Error!');
            return redirect('/invoice'); 

        }

        else{

            $pricing=request('pricing'); 
            $price = Product::select('whprice','bwhprice','pbwhprice','rprice','prprice','price')->where('productId',$productId)->first();
            $data = json_decode($price);
            $mytime = Carbon::now();
            $uuid = Idgenerator();//Str::uuid()->toString();
            $cart = new InvoiceCart();
            $cart->productId = $productId;
            $cart->cartQuantity = $qty;
            $cart->userId = Auth::user()->id;
            $cart->cartId = $uuid;
            $cart->price = $data->$pricing;
            $cart->companyId = getusercompanyId();
            
            $price=getpricing($pricing,$productId);

            if($price < 1){
                alert()->error('Product pricing can be zero', 'Error!');
                return redirect('/pos'); 
            }



            $cart->save();

            alert()->success('Product Added succesfully', 'Success!');
            return redirect('/invoice'); 

        }

    }


    public function updateinvoicequantity(Request $request){
       
       
     
       
        $validatedData = $request->validate([
            'product' => 'required',
            'quantity' => 'required|numeric',
            'cartId' => 'required',
            'pricing' => 'required',
            
        ]);


        if(!is_numeric(request('quantity'))){
            alert()->error('Product quantity should be integer', 'Error!');
            return redirect('/invoice'); 
        }


        $product=request('product');
        $pricing=request('pricing');
        $price=getpricing($pricing,$product);

        if($price < 1){
            alert()->error('Product pricing can be zero', 'Error!');
            return redirect('/pos'); 
        }
       
        $cart = InvoiceCart::find(request('cartId'));
        $cart->productId = request('product');
        $cart->cartQuantity = request('quantity');
        $cart->userId = Auth::user()->id;
        $cart->price = $price;
        $cart->cartId = request('cartId');
        $cart->save();
        alert()->success('Product Updated succesfully', 'Success!');
        return redirect('/invoice');  


    }



    public function deleteinvoiceitem($id){
        // $validatedData = $request->validate([
        //     'cartId' => 'required'
        // ]);
       
        $cart = InvoiceCart::find($id);
        $cart->delete();

        alert()->success('Product deleted succesfully', 'Success!');
        return redirect('/invoice');  


    }

    public function createinvoice(Request $request){ 
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'email' => 'nullable',
            'phone' => 'numeric',
            'invoiceType'=> 'required',
            'paymentStatus'=> 'required',
            'paymentType'=> 'required'
        ]);
        $branchId=getuserbranchId();
        $uuid = Idgenerator();  // Str::uuid()->toString();
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;


        $ivnote=DB::table('invoicenote')->where('invoicenote.companyId',$companyId)->get();
    
       $invoiceNote='';
       foreach ($ivnote as $note) {
        $invoiceNote = $note->note;
    
          }
       
       
        $cartdata =DB::table('invoicecart')->join('products','products.productId', '=', 'invoicecart.productId')->where('invoicecart.userId',$userInfo)->get();
       
         $count=count($cartdata);
        
      
        if($count>0){
            foreach ($cartdata as $carts) {
                $productdetails = new InvoiceDetails();
                $productdetails->id= Str::uuid()->toString();
                $productdetails->transactionId = $uuid;
                $productdetails->productId = $carts->productId;
                $productdetails->detailsQuantity = $carts->cartQuantity;
                $productdetails->userId = $carts->userId;
                $productdetails->companyId = $carts->companyId;;
                $productdetails->price =$carts->price;
                $productdetails->save();
    
      
               }

              
               $total_price = 0;

$cartdata =DB::table('invoicecart')->join('products','products.productId', '=', 'invoicecart.productId')->where('invoicecart.userId',$userInfo)->get();
       
$count=count($cartdata);

  if($count>0){
      foreach ($cartdata as $carts) {
    $total_price += $carts->cartQuantity*$carts->price;

      }

    }


 //store in client 

    $cartdata =DB::table('clients')->where('clients.phoneNumber',request('phone'))->get();
       
    $count=count($cartdata);
      
    
      if($count==0){
 
  $branchId=getuserbranchId();
  $companyId = getusercompanyId();
  $mytime = Carbon::now();
  $uuidss = Str::uuid()->toString();
  $client = new Client();
  $client->fullname = request('name');
  $client->phoneNumber = request('phone');
  $client->emailAddress = request('email');
  $client->gender = '';
  $client->dob = '';
  $client->dateCreated = $mytime->toDateTimeString();
  $client->clientId = $uuidss ;
  $client->companyId = $companyId;
  $client->branchId = $branchId;
  $client->save();

      }


           $discount=request('discount');
           $vatstatus=request('vat');
           $vatanddiscountinfo=vatcalculator($vatstatus,$total_price,$discount);

              $invoiceType= request('invoiceType');
              $cart = new Invoice();
              $cart->invoiceId = $uuid;
              $cart->customerName = request('name');
              $cart->email = request('email');
              $cart->userId = Auth::user()->id;
              $cart->phoneNumber = request('phone');
              $cart->address = request('address');
              $cart->amount = $vatanddiscountinfo[1];
              $cart->tendered = $total_price;
              $cart->invoiceType = request('invoiceType');
              $cart->status = 'COMPLETED';

                if($invoiceType=='Proforma Invoice'){
                    $cart->note = $invoiceNote;
                    
                }
                else{
                $cart->note ='';
                    
                }

                $cart->paymentStatus = request('paymentStatus');
                $cart->paymentType = request('paymentType');
                $cart->companyId = $companyId;
                $cart->branchId = $branchId;
            
                $cart->discount = $vatanddiscountinfo[0];
                $cart->vat =$vatanddiscountinfo[3];
                $cart->vatPercentage=$vatanddiscountinfo[4];
                $cart->vatDetails=json_encode($vatanddiscountinfo[2]) ;
                $cart->discountPercentage=$discount;
             
                $cart->save();
                DB::table('invoicecart')->where('userId',$userInfo)->delete();
                alert()->success('Invoice created succesfully', 'Success!');
                return redirect('/viewinvoice/'.$uuid.''); 
        }
        else{
            alert()->info('Cart is empty. Order cannot be processed', 'Error!');
            return redirect('/invoice'); 
        }
    }



    public function editinvoice(Request $request) 
    {

        $validatedData = $request->validate([
            'invoiceId' => 'required',
            'name' => 'required',
            'address' => 'nullable',
            'email' => 'nullable',
            'phone' => 'numeric',
            'invoiceType'=> 'required',
            'paymentStatus'=> 'required',
            'paymentType'=> 'required'
        ]);

                $cart = Invoice::find(request('invoiceId'));
                $cart->customerName = request('name');
                $cart->email = request('email');
                $cart->phoneNumber = request('phone');
                $cart->address = request('address');
                $cart->invoiceType = request('invoiceType');
                $cart->note = request('note');
                $cart->paymentStatus = request('paymentStatus');
                $cart->paymentType = request('paymentType');
                $cart->save();
                alert()->success('Invoice updated succesfully', 'Success!');
                return redirect('/allinvoice'); 


    }






    public function allinvoice() 
    {
        $branch = Branch::pluck('branchName','branchId');

        $usertype=getusertypeInfo();
        $branchId=getuserbranchId();

        if($usertype=="Admin"){

            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $branch = Branch::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('branchName','branchId');
            $details=DB::table('invoice')->orderBy('created_at','desc')->paginate(20);
            $userList = User::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('name','id');
            //$userList = User::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('name','id');
            $product = DB::table('products')->where('products.companyId',$companyId)->pluck('name','productId');  

            


            return view('invoice.sales',compact('details','branch','userList','product'));   

        }


        if($usertype=="SubAdmin"){

            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $details=DB::table('invoice')->where('invoice.userId',$userInfo)->where('invoice.branchId',$branchId)->orderBy('created_at','desc')->paginate(20);
            $branch = Branch::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('branchName','branchId');
            $userList = User::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('name','id');
            $product = DB::table('products')->where('products.companyId',$companyId)->pluck('name','productId');  

            


            return view('invoice.sales',compact('details','branch','userList','product'));
           
        

        }

          if($usertype=="none"){

            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $details=DB::table('invoice')->where('invoice.userId',$userInfo)->where('invoice.branchId',$branchId)->orderBy('created_at','desc')->get();
            $branch = Branch::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('branchName','branchId');
            $userList = User::where('companyId',$companyId)->where('branchId', '=',$branchId)->where('id', '=',$userInfo)->pluck('name','id');
            $product = DB::table('products')->where('products.companyId',$companyId)->pluck('name','productId');  

            


            return view('invoice.sales',compact('details','branch','userList','product'));
    
   
           }

        else{
          
            $details=DB::table('invoice')->orderBy('created_at','desc')->get();
            return view('invoice.sales',compact('details')); 

          }












    }




    public function invoicesalesdaterange(Request $request) 
    {


    
    
    $validatedData = $request->validate([
        'from' => 'required',
        'to' => 'required',
  
    ]);



    if(request('reportquested')=="ByAllsales"){

        $validatedData = $request->validate([
            'from'=>'required',
            'to'=>'required',
           ]);

           $datefrom = date("Y-m-d", strtotime(request('from')));  
           $dateto = date("Y-m-d", strtotime(request('to')));
     
           $companyId = getusercompanyId();    
           $userInfo = Auth::user()->id;
     
           $sql="Select * from invoice_transaction_details inner join products on products.productId=invoice_transaction_details.productId inner join users on users.id=invoice_transaction_details.userId where invoice_transaction_details.created_at between '$datefrom' and '$dateto' and  invoice_transaction_details.companyId='$companyId' ORDER BY invoice_transaction_details.created_at DESC ";
           $cartdata =DB::select(DB::raw($sql));
          
           return view('invoice.transactions-details-report',compact('cartdata')); 


      }



    if(request('reportquested')=="ByProducts"){

        $validatedData = $request->validate([
            'from'=>'required',
            'to'=>'required',
            'product'=>'required',
            
      
           ]);


           $datefrom = date("Y-m-d", strtotime(request('from')));  
           $dateto = date("Y-m-d", strtotime(request('to')));
           $products=request('product');
           $companyId = getusercompanyId();    
           $userInfo = Auth::user()->id;
     
           $sql="Select * from invoice_transaction_details inner join products on products.productId=invoice_transaction_details.productId inner join users on users.id=invoice_transaction_details.userId where invoice_transaction_details.created_at between '$datefrom' and '$dateto' and  invoice_transaction_details.companyId='$companyId' and products.productId='$products' ORDER BY invoice_transaction_details.created_at DESC ";
           $cartdata =DB::select(DB::raw($sql));
          
           return view('invoice.transactions-details-report',compact('cartdata'));   

    }



    if(request('reportquested')=="ByCustomers"){

        $validatedData = $request->validate([
            'from'=>'required',
            'to'=>'required',
            'customer'=>'required',
            'reportquested'=>'required'
        ]);
     
        $datefrom = date("Y-m-d", strtotime(request('from')));  
        $dateto = date("Y-m-d", strtotime(request('to')));

        $customer=request('customer');
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;
        $sql="Select * from invoice_transaction_details inner join products on products.productId=invoice_transaction_details.productId inner join users on users.id=invoice_transaction_details.userId inner join invoice on transactions.transactionId=invoice_transaction_details.transactionId where invoice_transaction_details.created_at between '$datefrom' and '$dateto' and  invoice_transaction_details.companyId='$companyId' and invoice.phoneNumber LIKE '%$customer%'  ORDER BY invoice_transaction_details.created_at DESC ";
        $cartdata =DB::select(DB::raw($sql));
        return view('invoice.transactions-details-report',compact('cartdata')); 
    }

   if(request('reportquested')=="BySales"){
     
    $validatedData = $request->validate([
    'from'=>'required',
    'to'=>'required',
    'branch'=>'required',
    'userList'=>'required',

   ]);


  $datefrom = date("Y-m-d", strtotime(request('from')));  
  $dateto = date("Y-m-d", strtotime(request('to')));

  $companyId = getusercompanyId();    
  $userInfo = Auth::user()->id;

if(request('branch')=="All" && request('userList')=="All") {

$sql="SELECT * FROM `invoice`  inner join users on users.id=invoice.userId   where invoice.created_at between '$datefrom' and '$dateto' and  invoice.companyId='$companyId' ORDER BY invoice.created_at DESC";
 
 $details =DB::select(DB::raw($sql));

//$details=DB::table('transactions')->whereBetween('created_at',[$datefrom,$dateto])->where('transactions.companyId',$companyId)->orderBy('created_at','desc')->toSql();

return view('invoice.transactions',compact('details'));

}



if(request('branch')=="All" && request('userList')!="Self") {
    $userInfo = request('userList');
   // $details=DB::table('transactions')->whereBetween('created_at',[$datefrom,$dateto])->where('transactions.userId',$userInfo)->where('transactions.companyId',$companyId)->orderBy('created_at','desc')->paginate(20);


    $sql="SELECT * FROM `invoice` inner join users on users.id=invoice.userId where invoice.created_at between '$datefrom' and '$dateto' and  invoice.userId='$userInfo' ORDER BY invoice.created_at DESC";
 
   $details =DB::select(DB::raw($sql));
   
   return view('invoice.transactions',compact('details'));


}



if(request('branch')!="All" && request('userList')!="Self") {
    $userInfo = request('userList');
    $branch=request('branch');
    $datefrom = date("Y-m-d", strtotime(request('from')));  
    $dateto = date("Y-m-d", strtotime(request('to')));
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    
  
    
     $sql="SELECT * FROM `invoice`inner join users on users.id=invoice.userId where invoice.created_at between '$datefrom' and '$dateto' and  invoice.userId='$userInfo' and invoice.branchId='$branch'  ORDER BY invoice.created_at DESC";
  
     $details =DB::select(DB::raw($sql));
    
     return view('invoice.transactions',compact('details'));

}


}    






}


   
    public function alltransactions() 
    {
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $details=DB::table('invoice')->where('invoice.userId',$userInfo)->orderBy('created_at','desc')->paginate(20);;

    //print_r($details);
    return view('invoice.transactions',compact('details'));   

    }


    public function transactiondetails($id) 
    {
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $cartdata =DB::table('invoice_transaction_details')->join('products','products.productId', '=', 'invoice_transaction_details.productId')->where('invoice_transaction_details.transactionId',$id)->get();
    return view('invoice.transactions-details',compact('cartdata'));   

    }


    public function updateproductdetailsquantity(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'newQuantity' => 'required|numeric',
            'previousQuantity' => 'required|numeric',
            'productId' => 'required',    
        ]);
        $stockStatus=getusercompanystockinfo();
        $qty= productquantity(request('productId'));
        if($stockStatus=="no"){
            $cart = TransactionDetail::find(request('id'));
            $cart->id = request('id');
            $cart->detailsQuantity= request('newQuantity');
            $cart->save();
                
            $id=request('id');
            updateOrderamount($id);


            alert()->success('Product quantity updated succesfully', 'Success!');
            return redirect('/pos');
        }
        else{

            $newQuantity =  request('newQuantity');
            $previousQuantity = request('previousQuantity');

          if($newQuantity==$previousQuantity){
            $cart = TransactionDetail::find(request('id'));
            $cart->id = request('id');
            $cart->detailsQuantity= request('newQuantity');
            $cart->save();
            alert()->success('Product quantity updated succesfully', 'Success!');
            return redirect('/pos');
        }
        if($newQuantity>$previousQuantity){

            $pquantity = Product::select('quantity')->where('productId',request('productId'))->first();
            $data = json_decode($pquantity);
            $proQuantity= $data->quantity-$qty;
            $pro = Product::find(request('productId'));
            $pro->quantity=$proQuantity;
            $cart->save();


            $id=request('id');
            updateOrderamount($id);

            $cart = TransactionDetail::find(request('id'));
            $cart->id = request('id');
            $cart->detailsQuantity= request('newQuantity');
            $cart->save();
            alert()->success('Product quantity updated succesfully', 'Success!');
            return redirect('/pos');   

        }

        if($newQuantity < $previousQuantity){

             $pquantity = Product::select('quantity')->where('productId',request('productId'))->first();  
             $data = json_decode($pquantity);
             $proQuantity= $data->quantity+$qty;
             $pro = Product::find(request('productId'));
             $pro->quantity=$proQuantity;
             $cart->save();

             $id=request('id');
             updateOrderamount($id);

             $cart = TransactionDetail::find(request('id'));
             $cart->id = request('id');
             $cart->detailsQuantity= request('newQuantity');
             $cart->save();
             alert()->success('Product quantity updated succesfully', 'Success!');
             return redirect('/pos');   



        }

        }
    }





    public function deletetransactionitem($id){

        $cart = TransactionDetail::find($id);
        $cart->delete();
        alert()->success('Product removed succesfully', 'Success!');
        return redirect('/pos');  
    }



    public function viewinvoice($id){


        $mytime = Carbon::now();

        $demo_string = preg_replace("/[^a-zA-Z,\"{}:]/", "",$mytime);;
       //echo $demo_string = str_replace(' ', '','',$mytime);
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;

        $company = DB::table('company')->where('companyId',$companyId)->get();
        $cartdata =DB::table('invoice_transaction_details')->join('products','products.productId', '=', 'invoice_transaction_details.productId')->where('invoice_transaction_details.transactionId',$id)->get();
        return view('invoice.invoice-details',compact('cartdata','company')); 
       
       }



       public function searchinvoice(Request $request)
       {
           $validatedData = $request->validate([
               'searchquery'=>'required',      
           ]);
   
           $companyId = getusercompanyId();

           $company = DB::table('company')->where('companyId',$companyId)->get();  
           $search = $request->searchquery;
           $sql="SELECT * FROM `invoice` where (invoiceId='$search' or customerName like '%$search%' or phoneNumber like '%$search%' or email like '%$search%' ) and  invoice.companyId='$companyId' ";
           $details =DB::select(DB::raw($sql));
           return view('invoice.transactions',compact('details')); 


           //return view('invoice.invoice-details',compact('cartdata','company'));  
      
       }



       public function cancelinvoice($id){

        $mytime = Carbon::now();
        $demo_string = preg_replace("/[^a-zA-Z,\"{}:]/", "",$mytime);;
       //echo $demo_string = str_replace(' ', '','',$mytime);
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;

        //$company = DB::table('company')->where('companyId',$companyId)->get();
       // $cartdata =DB::table('transaction_details')->join('products','products.productId', '=', 'transaction_details.productId')->where('transaction_details.transactionId',$id)->get();
        //return view('pos.invoice-details',compact('cartdata','company')); 

        
        $sql="SELECT * FROM `invoice` where invoiceId='$id' and  invoice.status='CANCELLED' LIMIT 1";
        $details =DB::select(DB::raw($sql));
        $count=count($details);

        if($count>0){

            alert()->error('Order has been cancelled already', 'Error!');
                return redirect('/allsales'); 
        }
         
       
        $pro = invoice::find($id);
                
        $pro->status='CANCELLED';
        
        $pro->save();

        alert()->success('Order cancelled succesfully', 'Success!');
        return redirect('/allinvoice'); 





       
       }
    


}
