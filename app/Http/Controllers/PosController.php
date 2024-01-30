<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\CampaignReport;
use Illuminate\Support\Facades\DB;
use SweetAlert;
use App\Models\Product;
use App\Models\ReceiptNote;
use App\Models\Vat;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\ProductsCategory;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\Branch;
use App\Models\User;
use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Collection;
use Rap2hpoutre\FastExcel\FastExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportSales;
use App\Exports\ExportInventory;
use App\Exports\ExportInventoryLog;
use App\Models\InventoryLog;
use Response;



class PosController extends Controller
{
    
    public function pos() 
    {

    $branchId=getuserbranchId();    
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    //$cart =DB::table('cart')->join('products','products.productId', '=', 'cart.productId')->where('cart.userId',$userInfo)->get();
    
    $sql="select *,cart.price as cartprice from cart inner join products ON products.productId=cart.productId where cart.userId='$userInfo' " ;
    $cart =  DB::select(DB::raw($sql));
    
    
    $products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->join('inventory', 'inventory.productId', '=', 'products.productId')->where('products.companyId',$companyId)->where('inventory.branchId',$branchId)->get();
    return view('pos.index',compact('products','cart'));   

    }


    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'product' => 'nullable',
            'quantity' => 'nullable',
            'pricing' => 'required',
            'barcodeinput'=>'nullable'  
        ]);

        if(empty(request('barcodeinput')) && empty(request('product'))  ){
            alert()->error('Barcode or product cannot be empty', 'Error!');
            return redirect('/pos'); 
        }


        $feature="pos";
        $data=getCompanySubcriptionDetails($feature);
       
   if(empty($data)){


   }
 elseif(!$data[0]){   
        alert()->error($data[1], 'Error!');
        return redirect($data[2]);
        }
    


        $branchId=getuserbranchId(); 
        $productId=0;
        $qty=0;

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
         $pquantity = Cart::where('productId',$productId)->where('userId', Auth::user()->id)->get();
         $count=count($pquantity);
        if($count==1){
            alert()->error('Product already in cart', 'Error!');
            return redirect('/pos');
        }
        $stockStatus=getusercompanystockinfo();
        if($stockStatus=="yes"){
           $pquantity = Inventory::select('invQuantity','inventoryId','branchId')->where('productId',$productId)->where('branchId',$branchId)->first();
            $data = json_decode($pquantity);
            $proQuantity= $data->invQuantity;
        if($proQuantity==0 || $qty>$proQuantity ){
                alert()->error('Product out of stock', 'Error!');
                 return redirect('/pos'); 
            }
        else{
          $pricing=request('pricing');
          $price = Product::select('whprice','bwhprice','pbwhprice','rprice','prprice','price')->where('productId',$productId)->first();
          $data = json_decode($price);
          $mytime = Carbon::now();
          $uuid = Idgenerator();//Str::uuid()->toString();
          $cart = new Cart();
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
          return redirect('/pos'); 
            }



        }

        else{

            $pricing=request('pricing');
                
            $price = Product::select('whprice','bwhprice','pbwhprice','rprice','prprice','price')->where('productId',$productId)->first();
            $data = json_decode($price);
            $mytime = Carbon::now();
            $uuid = Idgenerator();//Str::uuid()->toString();
            $cart = new Cart();
            $cart->productId = $productId;
            $cart->cartQuantity = $qty;
            $cart->userId = Auth::user()->id;
            $cart->cartId = $uuid;
            $cart->price = $data->$pricing;
            $cart->companyId = getusercompanyId();
            $cart->save();
            alert()->success('Product Added succesfully', 'Success!');
            return redirect('/pos'); 
        }
    
    }



    public function updateinventory(Request $request) 
    {
        $validatedData = $request->validate([
            'product' => 'required',
            'quantity' => 'required|numeric',
            'branchId'=>'required']
    );


        if(!is_numeric(request('quantity'))){
            alert()->error('Product quantity should be integer', 'Error!');
            return redirect('/inventory'); 
        }
        $uuid = Idgenerator();
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;
        $branchId = request('branchId');
        $Quantity = request('quantity');
        $pquantity = Inventory::select('invQuantity','inventoryId')->where('productId',request('product'))->where('branchId',request('branchId'))->first();
        $data = json_decode($pquantity);
        $proQuantity= $data->invQuantity;
        $total=$proQuantity+$Quantity;
        $inventoryId=$data->inventoryId;
       
        if(is_numeric($total)){
            $pro = Inventory::find($inventoryId);
            $pro->invQuantity=$total;
            
            $pro->save();

              $product= request('product');


              inventorylog($branchId,$product,$total,$proQuantity,$inventoryId,$companyId,$userInfo,$uuid);

                // $uuid2=Str::uuid()->toString();
                // $productdetails = new InventoryLog();
                // $productdetails->branchId = $branchId;
                // $productdetails->productId = $product;
                // $productdetails->inventoryQuantityBefore =$proQuantity;
                // $productdetails->inventoryQuantityAfter =$total;
                // $productdetails->inventoryId = $inventoryId;
                // $productdetails->inventorylogId =$uuid2;
                // $productdetails->companyId =$companyId;
                // $productdetails->dateCreated = date('Y-m-d');
                // $productdetails->userId= $userInfo;  
                // $productdetails->save();
             
        
        }
        
        alert()->success('Product Quantity Updated succesfully', 'Success!');
        return redirect("/branchinventory/$branchId"); 



    }





    public function updatequantity(Request $request){

        $validatedData = $request->validate([
            'product' => 'required',
            'quantity' => 'required|numeric',
            'cartId' => 'required',
            'pricing' => 'required',
            
        ]);


        if(!is_numeric(request('quantity'))){
            alert()->error('Product quantity should be integer', 'Error!');
            return redirect('/pos'); 
        }


       
        $product=request('product');
        $pricing=request('pricing');
        $price=getpricing($pricing,$product);

        if($price < 1){
            alert()->error('Product pricing can be zero', 'Error!');
            return redirect('/pos'); 
        }
       
        $cart = Cart::find(request('cartId'));
        $cart->productId = request('product');
        $cart->cartQuantity = request('quantity');
        $cart->userId = Auth::user()->id;
        $cart->price = $price;
        $cart->cartId = request('cartId');
        $cart->save();
        alert()->success('Product Updated succesfully', 'Success!');
        return redirect('/pos');  
    }



    public function deleteitem($id){
        $cart = Cart::find($id);
        $cart->delete();
        alert()->success('Product deleted succesfully', 'Success!');
        return redirect('/pos');  
    }



    public function creatorder(Request $request){ 
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'email' => 'nullable',
            'phone' => 'numeric',
            'payment' => 'required',
            'vat'=>'required',
            'discount'=>'required',
            'paymentStatus'=>'required'
        ]);
        $branchId=getuserbranchId();
        $uuid = Idgenerator();  // Str::uuid()->toString();
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;
        
       // $cartdata =DB::table('cart')->join('products','products.productId', '=', 'cart.productId')->where('cart.userId',$userInfo)->get();
       
       $ivnote=DB::table('receiptnote')->where('receiptnote.companyId',$companyId)->get();
    
       $invoiceNote='';
       foreach ($ivnote as $note) {
        $invoiceNote = $note->note;
    
          }

        $sql="select *,cart.price as cartprice from cart inner join products ON products.productId=cart.productId where cart.userId='$userInfo' " ;
        $cartdata =  DB::select(DB::raw($sql));
        $count=count($cartdata);

        if($count>0){
            foreach ($cartdata as $carts) {
                $productdetails = new TransactionDetail();
                $productdetails->id= Str::uuid()->toString();
                $productdetails->transactionId = $uuid;
                $productdetails->productId = $carts->productId;
                $productdetails->detailsQuantity = $carts->cartQuantity;
                $productdetails->userId = $carts->userId;
                $productdetails->companyId = $carts->companyId;;
                $productdetails->price =$carts->cartprice;
                $productdetails->save();
    
                 $stockStatus=getusercompanystockinfo();
                 if($stockStatus=="yes"){

            //$products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->join('inventory', 'inventory.productId', '=', 'products.productId')->where('products.companyId',$companyId)->where('inventory.branchId',$id)->paginate(20);



            $pquantity = Inventory::select('invQuantity','inventoryId')->where('productId',$carts->productId)->where('branchId',$branchId)->first();
            $data = json_decode($pquantity);
            $proQuantity= $data->invQuantity;
            $cartQty=$carts->cartQuantity;
            $inventoryId=$data->inventoryId;


            // $pquantity = Product::select('quantity')->where('productId',$carts->productId)->first();
            // $data = json_decode($pquantity);
            // $proQuantity= $data->quantity;
            // $cartQty=$carts->cartQuantity;

             $totaldeduction=$proQuantity-$cartQty;

            if(is_numeric($totaldeduction)){
                $pro = Inventory::find($inventoryId);
                $pro->invQuantity=$totaldeduction;
                $pro->save();


            inventorylog($branchId,$carts->productId,$totaldeduction,$proQuantity,$inventoryId,$companyId,$userInfo,$uuid);


            }
            else{ }

             }

               }

              
               $total_price = 0;

// $cartdata =DB::table('cart')->join('products','products.productId', '=', 'cart.productId')->where('cart.userId',$userInfo)->get();
       
// $count=count($cartdata);


$sql="select *,cart.price as cartprice from cart inner join products ON products.productId=cart.productId where cart.userId='$userInfo' " ;
$cartdata =  DB::select(DB::raw($sql));
$count=count($cartdata);

  if($count>0){
      foreach ($cartdata as $carts) {
    $total_price += $carts->cartQuantity*$carts->cartprice;

      }

    }


 //store in client 

    $cartdata =DB::table('clients')->where('clients.phoneNumber',request('phone'))->get();
       
    $count=count($cartdata);
      
    
      if($count==0){

$cg = DB::table('contact_group')->where('name', '=','Pos Customers')->where('companyId', '=',$companyId)->first();
$contactGroupId=$cg->contactGroupId;
 
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
  $client->contactgroupId = $contactGroupId;
  $client->save();



      }
      
      $finaltotal=0;
      $discount=request('discount');

       $vatstatus=request('vat');
       $vat=request('vat');

       if($vatstatus=="yes"){

        $check=vatsetupcheck();
       
        if(!$check){
    
        alert()->error('Vat not configured please configure and proceed', 'Error!');
        return redirect('/pos');     
        }

       }

       
       
       $vatanddiscountinfo = vatcalculator($vatstatus,$total_price,$discount);
      
        $paymentStatus=request('paymentStatus');
        $cart = new Transaction();
        $cart->transactionId = $uuid;
        $cart->customer = request('name');
        $cart->email = request('email');
        $cart->userId = Auth::user()->id;
        $cart->phone = request('phone');
        $cart->address = request('address');
        $cart->paymentMethod = request('payment');
        $cart->totalAmount = $vatanddiscountinfo[1];
        $cart->tendered = $total_price;
        $cart->companyId = $companyId;
        $cart->branchId = $branchId;
        $cart->status = 'COMPLETED';
        $cart->note=$invoiceNote;
        $cart->dateCreated=date("Y-m-d");
        $cart->discount = $vatanddiscountinfo[0];
        $cart->vat =$vatanddiscountinfo[3];
        $cart->vatPercentage=$vatanddiscountinfo[4];
        $cart->vatDetails=json_encode($vatanddiscountinfo[2]) ;//;   
        $cart->discountPercentage=$discount;
        $cart->paymentStatus=$paymentStatus;
        $cart->save();

        DB::table('cart')->where('userId', $userInfo)->delete();
        alert()->success('Order created succesfully', 'Success!');
        return redirect('/viewreceipt/'.$uuid.'');

                
        }
        else{
            alert()->info('Cart is empty. Order cannot be processed', 'Error!');
            return redirect('/pos'); 
        }
    }

    public function allsales() 
    {
        $usertype=getusertypeInfo();
        $branchId=getuserbranchId();

        $timestemp =date('Y-m-d H:i:s');
        $year = Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->year;
        $month = str_pad(Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->month, 2, '0', STR_PAD_LEFT);;
       
        $date=$year.'-'.$month;
       
        $totalsales=  round(DB::table('transactions')->where('created_at', 'like', '%'.$date.'%')->sum('transactions.totalAmount'), 2);

        

        if($usertype=="Admin"){

            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $branch = Branch::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('branchName','branchId');
            $details=DB::table('transactions')->orderBy('created_at','desc')->paginate(20);
            $userList = User::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('name','id');
            $product = DB::table('products')->where('products.companyId',$companyId)->pluck('name','productId');  
          
            return view('pos.sales',compact('details','branch','userList','product','totalsales'));   

        }


        if($usertype=="SubAdmin"){

            $companyId = getusercompanyId();    
            $userInfo = Auth::user()->id;
            $details=DB::table('transactions')->where('transactions.userId',$userInfo)->where('transactions.branchId',$branchId)->orderBy('created_at','desc')->paginate(20);
            $branch = Branch::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('branchName','branchId');
            $userList = User::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('name','id');
            $product = DB::table('products')->where('products.companyId',$companyId)->pluck('name','productId'); 
            return view('pos.sales',compact('details','branch','userList','product','totalsales'));      

        }

          if($usertype=="none"){
            $companyId = getusercompanyId();  
            $userInfo = Auth::user()->id;
            $details=DB::table('transactions')->where('transactions.userId',$userInfo)->where('transactions.branchId',$branchId)->orderBy('created_at','desc')->get();
            $branch = Branch::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('branchName','branchId');
            $userList = User::where('companyId',$companyId)->where('branchId', '=',$branchId)->where('id', '=',$userInfo)->pluck('name','id');
            $product = DB::table('products')->where('products.companyId',$companyId)->pluck('name','productId'); 
            return view('pos.sales',compact('details','branch','userList','product','totalsales'));     
   
           }

      

    }







    public function salesdaterange(Request $request) 
    {


        if(request('reportquested')=="ByAllsales"){

            $validatedData = $request->validate([
                'from'=>'required',
                'to'=>'required',
               ]);

               $datefrom = date("Y-m-d", strtotime(request('from')));  
               $dateto = date("Y-m-d", strtotime(request('to')));
         
               $companyId = getusercompanyId();    
               $userInfo = Auth::user()->id;
         
               $sql="Select * from transaction_details inner join products on products.productId=transaction_details.productId inner join users on users.id=transaction_details.userId where transaction_details.created_at between '$datefrom' and '$dateto' and  transaction_details.companyId='$companyId' ORDER BY transaction_details.created_at DESC ";
               $cartdata =DB::select(DB::raw($sql));
              
               return view('pos.transactions-details-report',compact('cartdata')); 


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
         
               $sql="Select * from transaction_details inner join products on products.productId=transaction_details.productId inner join users on users.id=transaction_details.userId where transaction_details.created_at between '$datefrom' and '$dateto' and  transaction_details.companyId='$companyId' and products.productId='$products' ORDER BY transaction_details.created_at DESC ";
               $cartdata =DB::select(DB::raw($sql));
              
               return view('pos.transactions-details-report',compact('cartdata'));  

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
            $sql="Select * from transaction_details inner join products on products.productId=transaction_details.productId inner join users on users.id=transaction_details.userId inner join transactions on transactions.transactionId=transaction_details.transactionId where transaction_details.created_at between '$datefrom' and '$dateto' and  transaction_details.companyId='$companyId' and transactions.customer LIKE '%$customer%'  ORDER BY transaction_details.created_at DESC ";
            $cartdata =DB::select(DB::raw($sql));
            return view('pos.transactions-details-report',compact('cartdata')); 
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

   $sql="SELECT * FROM `transactions`  inner join users on users.id=transactions.userId   where dateCreated between '$datefrom' and '$dateto' and  transactions.companyId='$companyId' ORDER BY dateCreated DESC";
     
     $details =DB::select(DB::raw($sql));
    
    //$details=DB::table('transactions')->whereBetween('created_at',[$datefrom,$dateto])->where('transactions.companyId',$companyId)->orderBy('created_at','desc')->toSql();
    
    return view('pos.transactions',compact('details'));

    }



    if(request('branch')=="All" && request('userList')!="Self") {
        $userInfo = request('userList');
       // $details=DB::table('transactions')->whereBetween('created_at',[$datefrom,$dateto])->where('transactions.userId',$userInfo)->where('transactions.companyId',$companyId)->orderBy('created_at','desc')->paginate(20);
    

        $sql="SELECT * FROM `transactions` inner join users on users.id=transactions.userId where dateCreated between '$datefrom' and '$dateto' and  transactions.userId='$userInfo' ORDER BY dateCreated DESC";
     
       $details =DB::select(DB::raw($sql));
       
       return view('pos.transactions',compact('details')); 
    

    }


    
    if(request('branch')!="All" && request('userList')!="Self") {
        $userInfo = request('userList');
        $branch=request('branch');

      
        
         $sql="SELECT * FROM `transactions`inner join users on users.id=transactions.userId where dateCreated between '$datefrom' and '$dateto' and  transactions.userId='$userInfo' and transactions.branchId='$branch'  ORDER BY dateCreated DESC";
      
         $details =DB::select(DB::raw($sql));
        
         return view('pos.transactions',compact('details')); 
 
        //  $reportType = request('reportType');
 
        //  if($reportType=="Webpage"){
         
              
         
        //      }
         
        //      else{
        //         $sql="SELECT transactions.transactionId,transactions.customer,transactions.totalAmount,transactions.email,transactions.phone,transactions.paymentMethod,transactions.discount,transactions.vat,transactions.vatPercentage,transactions.discountPercentage,transactions.status,transactions.dateCreated,users.name FROM `transactions` inner join users on users.id=transactions.userId where transactions.dateCreated between '$datefrom' and '$dateto' and  transactions.userId='$userInfo' and transactions.branchId='$branch'  ORDER BY dateCreated DESC";
     
        //         $details =DB::select(DB::raw($sql));
                
        //          return Excel::download(new ExportSales($details), "SalesReport-$datefrom-$dateto.xlsx");
     
        //      }
        
    
    }


   }    
    
    
   
    
    
    


    }





    public function exportInventory($id) 
    {

    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
  
    $sql="SELECT * FROM `inventory` inner join products on inventory.productId=products.productId where inventory.branchId='$id' and inventory.companyId='$companyId' ";

     $details =DB::select(DB::raw($sql));
     return Excel::download(new ExportInventory($details),"Inventory.xlsx");

    }
   

    public function exportInventoryLog(Request $request) 
    {

        $validatedData = $request->validate([
            'from'=>'required',
            'to'=>'required',
            'branch'=>'required',
           
      
        ]);

    $datefrom = date("Y-m-d", strtotime(request('from')));  
    $dateto = date("Y-m-d", strtotime(request('to')));
    
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $branch=request('branch');
    
    $sql="SELECT inventorylog.inventoryId,products.name,inventorylog.inventoryQuantityBefore,inventorylog.inventoryQuantityAfter,inventorylog.dateCreated,users.username FROM `inventorylog` inner join products on inventorylog.productId=products.productId inner join users on users.id=inventorylog.userId where dateCreated between '$datefrom' and '$dateto' and inventorylog.branchId='$branch'";
    $details =DB::select(DB::raw($sql));
    return Excel::download(new ExportInventoryLog($details),"InventoryLog.xlsx");

    }

    

    public function transactiondetails($id) 
    {
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $cartdata =DB::table('transaction_details')->join('products','products.productId', '=', 'transaction_details.productId')->where('transaction_details.transactionId',$id)->get();
    return view('pos.transactions-details',compact('cartdata'));   

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
             $pro->save();

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



    public function inventory(){
    //  $companyId = getusercompanyId();    
    // $userInfo = Auth::user()->id;
    // $products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->where('products.companyId',$companyId)->paginate(20);  
    // return view('pos.inventory',compact('products'));   

    $usertype= productadditiontostock();

 
    $usertype=getusertypeInfo();
    $branchId=getuserbranchId();

    if($usertype=="Admin"){

     $companyId = getusercompanyId();
     $products = DB::table('branches')->where('companyId',$companyId)->get(); 
     return view('pos.inventory')->with('records',$products);

    }


    if($usertype=="SubAdmin"){

     $companyId = getusercompanyId();
     $products = DB::table('branches')->where('companyId',$companyId)->get(); 
     return view('pos.inventory')->with('records',$products);

    }

      if($usertype=="none"){

        $companyId = getusercompanyId();
        $products = DB::table('branches')->where('companyId',$companyId)->get(); 
        return view('pos.inventory')->with('records',$products);

       }

    else{

      
        $products = DB::table('branches')->get(); 
        return view('pos.inventory')->with('records',$products);

    }



    }

    public function branchinventory($id){ 
      $branch=$id;
      $companyId = getusercompanyId();    
      $userInfo = Auth::user()->id;
      $products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->join('inventory', 'inventory.productId', '=', 'products.productId')->where('products.companyId',$companyId)->where('inventory.branchId',$id)->paginate(200);  
      
      $type='branch';
      
      $branches=getbranchforstocktransfer($id,$type);

      return view('pos.branchinventory',compact('products','branch','branches'));   


    }

      
     public function viewreceipt($id){

        $mytime = Carbon::now();
        $demo_string = preg_replace("/[^a-zA-Z,\"{}:]/", "",$mytime);;
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;
        $company = DB::table('company')->where('companyId',$companyId)->get();
        $cartdata =DB::table('transaction_details')->join('products','products.productId', '=', 'transaction_details.productId')->where('transaction_details.transactionId',$id)->get();
        return view('pos.invoice-details',compact('cartdata','company')); 

    }


    public function viewminireceipt($id){

        $mytime = Carbon::now();
        $demo_string = preg_replace("/[^a-zA-Z,\"{}:]/", "",$mytime);;
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;
        $company = DB::table('company')->where('companyId',$companyId)->get();
        $cartdata =DB::table('transaction_details')->join('products','products.productId', '=', 'transaction_details.productId')->where('transaction_details.transactionId',$id)->get();
        return view('pos.invoice-details-mini',compact('cartdata','company')); 

    }


    

       public function cancelreceipt($id){

        $mytime = Carbon::now();
        $demo_string = preg_replace("/[^a-zA-Z,\"{}:]/", "",$mytime);;
       //echo $demo_string = str_replace(' ', '','',$mytime);
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;
        $branchId=getuserbranchId();
        //$company = DB::table('company')->where('companyId',$companyId)->get();
       // $cartdata =DB::table('transaction_details')->join('products','products.productId', '=', 'transaction_details.productId')->where('transaction_details.transactionId',$id)->get();
        //return view('pos.invoice-details',compact('cartdata','company')); 

        
        $sql="SELECT * FROM `transactions` where transactionId='$id' and  transactions.status='CANCELLED' LIMIT 1";
        $details =DB::select(DB::raw($sql));
        $count=count($details);

        if($count>0){

            alert()->error('Order has been cancelled already', 'Error!');
                return redirect('/allsales'); 
        }
         
       
        $sql="select *,transaction_details.price as cartprice from transaction_details inner join products ON products.productId=transaction_details.productId where transaction_details.transactionId='$id' " ;
        $cartdata =  DB::select(DB::raw($sql));
         $count=count($cartdata);

        if($count>0){
            foreach ($cartdata as $carts) {
                $productdetails = new TransactionDetail();
                $productdetails->id= Str::uuid()->toString();
                //$productdetails->transactionId = $uuid;
                $productdetails->productId = $carts->productId;
                $productdetails->detailsQuantity = $carts->detailsQuantity;
                $productdetails->userId = $carts->userId;
                $productdetails->companyId = $carts->companyId;;
                $productdetails->price =$carts->cartprice;
                //$productdetails->save();
   
                 $stockStatus=getusercompanystockinfo();
                 if($stockStatus=="yes"){

            //$products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->join('inventory', 'inventory.productId', '=', 'products.productId')->where('products.companyId',$companyId)->where('inventory.branchId',$id)->paginate(20);

            $branch=getbranchfromTransaction($id);

            $pquantity = Inventory::select('invQuantity','inventoryId')->where('productId',$carts->productId)->where('companyId',$companyId)->where('branchId',$branch)->first();
            $data = json_decode($pquantity);
            $inventoryId=$data->inventoryId;
            $proQuantity= $data->invQuantity;
            $cartQty=$carts->detailsQuantity;
            $totaldeduction=$proQuantity+$cartQty;
            
            if(is_numeric($totaldeduction)){
                $pro = Inventory::find($inventoryId);
                
                $pro->invQuantity=$totaldeduction;
                
                $pro->save();

               
                inventorylog($branchId,$carts->productId,$totaldeduction,$proQuantity,$inventoryId,$companyId,$userInfo,$carts->transactionId);

                $pro = Transaction::find($carts->transactionId);
                
                $pro->status='CANCELLED';
                
                $pro->save();

             

            }
            else{ 



            }

             }

               }


               alert()->success('Order cancelled succesfully', 'Success!');
                return redirect('/allsales'); 



            }





       
       }
    

    public function searchtransaction(Request $request)
    {
      
        $validatedData = $request->validate([
            'searchquery'=>'required',      
        ]);

        $companyId = getusercompanyId();  
    	$search = $request->searchquery;
        $sql="SELECT * FROM `transactions` where (transactionId='$search' or customer like '%$search%' or phone like '%$search%' or email like '%$search%' ) and  transactions.companyId='$companyId' ORDER BY dateCreated DESC";
        $details =DB::select(DB::raw($sql));
        return view('pos.transactions',compact('details'));  
   
    }



    public function export(Request $request)
    {
  

//  $pro=Product::select('name','productId')->get();

// //  print_r($pro);
// //  (new FastExcel($pro))->export('file.xlsx');
//   return Excel::download(new ExportSales, 'users.xlsx');


    }





  public function managereceiptnote() 
  {
  $branchId=getuserbranchId();    
  $companyId = getusercompanyId();    
  $userInfo = Auth::user()->id;
  $note=DB::table('receiptnote')->where('receiptnote.companyId',$companyId)->get();

  return view('pos.receiptnote.index',compact('note'));   

  }


  public function addreceiptnote(Request $request)
  {

      return view('pos.receiptnote.add');   

  
  }


  public function storenote(Request $request)
  {

      $validatedData = $request->validate([
          'note' => 'required',  
      ]);


      $companyId = getusercompanyId();    
      $userInfo = Auth::user()->id;

      $sql="SELECT * FROM `receiptnote` where companyId='$companyId' ";
      $details =DB::select(DB::raw($sql));

      if(count($details)>0){

        alert()->error('More than one Receipt Note cannot be added', 'Warning!');
        return redirect('/managereceiptnote');

      }

      else{

        $mytime = Carbon::now();
        $uuid = Idgenerator();//Str::uuid()->toString();
        $cart = new ReceiptNote();
        $cart->noteId = $uuid;
        $cart->note = request('note');
        $cart->companyId = getusercompanyId();
        $cart->save();
        alert()->success('Receipt Note Added succesfully', 'Success!');
        return redirect('/managereceiptnote'); 

      }

    

  
  }



  public function editreceiptnote(ReceiptNote $noteId)
  {

      //$category = Branch::where('branchId', $branchId)->get();
      return view('pos.receiptnote.edit', [
          'user' => $noteId,
        
      ]);

  
  }

  

  public function updatereceiptnote(Request $request)
  {

      $validatedData = $request->validate([
          'note' => 'required',
          'noteId' => 'required',    
      ]);
      
      $mytime = Carbon::now();
      $uuid = Idgenerator();//Str::uuid()->toString();
      $cart = ReceiptNote::find(request('noteId'));
      $cart->noteId =request('noteId');
      $cart->note = request('note');
      $cart->save();
      alert()->success('Receipt Note Updated succesfully', 'Success!');
      return redirect('/managereceiptnote'); 

  
  }






  public function viewTransactionLog($id){

    $mytime = Carbon::now();
    $demo_string = preg_replace("/[^a-zA-Z,\"{}:]/", "",$mytime);;
   //echo $demo_string = str_replace(' ', '','',$mytime);
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $branchId=getuserbranchId();

    $sql="SELECT * FROM `inventorylog` inner join users on users.id=inventorylog.userId inner join products on products.productId=inventorylog.productId where inventorylog.transactionId='$id' ";
    $details =DB::select(DB::raw($sql));
    
    return view('pos.transactionlog',compact('details')); 
    



  }






  public function managevatsetup() 
  {
  $branchId=getuserbranchId();    
  $companyId = getusercompanyId();    
  $userInfo = Auth::user()->id;
  $note=DB::table('vat')->where('vat.companyId',$companyId)->get();
  return view('pos.vat.index',compact('note')); 

  }

  


  public function addvat(Request $request)
  {

      return view('pos.vat.add');   

  
  }


  public function storevat(Request $request)
  {

      $validatedData = $request->validate([
          'rate' => 'required', 
          'name' => 'required', 
          'vatType' => 'required', 
      ]);


      $companyId = getusercompanyId();    
      $userInfo = Auth::user()->id;

      $vatType= request('vatType');

      if($vatType=='vat'){
        $sql="SELECT * FROM `vat` where companyId='$companyId' and vatType='vat' ";
        $details =DB::select(DB::raw($sql));
  
        if(count($details)>0){
  
          alert()->error('More than one vat flat rate cannot be added', 'Warning!');
          return redirect('/managevatsetup');
  
        }

      }

      else{

        $mytime = Carbon::now();
        $uuid = Idgenerator();//Str::uuid()->toString();
        $cart = new Vat();
        $cart->vatId = $uuid;
        $cart->name = request('name');
        $cart->rate = request('rate');
        $cart->vatType= request('vatType');
        $cart->companyId = getusercompanyId();
        $cart->save();
        alert()->success('Vat Added succesfully', 'Success!');
        return redirect('/managevatsetup');

      }

    

  
  }



  public function editvat(Vat $vatId)
  {

      //$category = Branch::where('branchId', $branchId)->get();
      return view('pos.vat.edit', [
          'user' => $vatId,
        
      ]);

  
  }

  

  public function updatevat(Request $request)
  {

      $validatedData = $request->validate([
          'rate' => 'required',
          'vatId' => 'required',  
          'name' => 'required',
          'vatType' => 'required',  
      ]);
      
      $mytime = Carbon::now();
      $uuid = Idgenerator();//Str::uuid()->toString();
      $cart = Vat::find(request('vatId'));

     // $cart->vatId =request('vatId');
      $cart->name =request('name');
      $cart->rate = request('rate');
      $cart->vatType = request('vatType');
      $cart->save();
      alert()->success('Vat Updated succesfully', 'Success!');
      return redirect('/managevatsetup');

  
  }



  public function editreceipt(Request $request) 
  {

      $validatedData = $request->validate([
          'invoiceId' => 'required',
          'name' => 'required',
          'address' => 'nullable',
          'email' => 'nullable',
          'phone' => 'numeric',
          'paymentStatus'=> 'required',
          'paymentType'=> 'required'
      ]);

              $cart = Transaction::find(request('invoiceId'));
              $cart->customer = request('name');
              $cart->email = request('email');
              $cart->phone = request('phone');
              $cart->address = request('address');
              $cart->note = request('note');
              $cart->paymentStatus = request('paymentStatus');
              $cart->paymentMethod = request('paymentType');
              $cart->save();
              alert()->success('Receipt updated succesfully', 'Success!');
              return redirect('/allsales'); 



            //   $paymentStatus=request('paymentStatus');
            //   $cart = new Transaction();
            //   $cart->transactionId = $uuid;
            //   $cart->customer = request('name');
            //   $cart->email = request('email');
            //   $cart->userId = Auth::user()->id;
            //   $cart->phone = request('phone');
            //   $cart->address = request('address');
            //   $cart->paymentMethod = request('payment');
            //   $cart->totalAmount = $vatanddiscountinfo[1];
            //   $cart->tendered = $total_price;
            //   $cart->companyId = $companyId;
            //   $cart->branchId = $branchId;
            //   $cart->status = 'COMPLETED';
            //   $cart->note=$invoiceNote;
            //   $cart->dateCreated=date("Y-m-d");
            //   $cart->discount = $vatanddiscountinfo[0];
            //   $cart->vat =$vatanddiscountinfo[3];
            //   $cart->vatPercentage=$vatanddiscountinfo[4];
            //   $cart->vatDetails=json_encode($vatanddiscountinfo[2]) ;//;   
            //   $cart->discountPercentage=$discount;
            //   $cart->paymentStatus=$paymentStatus;
            //   $cart->save();


  }


  public function transferstock(Request $request){
  
    $validatedData = $request->validate([
        'frombranchId' => 'required',
        'tobranchId' => 'required',  
        'quantity' => 'required|numeric',
        'productId' => 'required', 
    ]);

    $uuid = Idgenerator();
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $frombranchId=request('frombranchId');
    $tobranchId=request('tobranchId');
    $quantity=request('quantity');
    $productId=request('productId');


    if(!is_numeric(request('quantity'))){
        alert()->error('Product quantity should be integer', 'Error!');
         return redirect("/branchinventory/$frombranchId");
    }


    //frombranchId
    $branchId = $frombranchId;
    $Quantity = request('quantity');
    $pquantity = Inventory::select('invQuantity','inventoryId')->where('productId',request('productId'))->where('branchId',$branchId)->first();

    $data = json_decode($pquantity);
    $proQuantity= $data->invQuantity;
    $inventoryId=$data->inventoryId;
   


    if($proQuantity>=$quantity){


        $transferType='1';
        $userId=$userInfo;

     stocktransferlog($frombranchId,$productId,$tobranchId,$userId,$quantity,$companyId,$transferType);


    $total=$proQuantity-$Quantity;   
    $pro = Inventory::find($inventoryId);
    $pro->invQuantity=$total;
        
    $pro->save();
    $product= request('productId');

    
    inventorylog($branchId,$product,$total,$proQuantity,$inventoryId,$companyId,$userInfo,$uuid);


    $branchId = $tobranchId;
    $Quantity = request('quantity');
    $pquantity = Inventory::select('invQuantity','inventoryId')->where('productId',request('productId'))->where('branchId',$branchId)->first();

    $data = json_decode($pquantity);
    $proQuantity= $data->invQuantity;
    $inventoryId=$data->inventoryId;


    $total=$proQuantity+$Quantity;   
    $pro = Inventory::find($inventoryId);
    $pro->invQuantity=$total;
        
    $pro->save();
    $product= request('productId');
    inventorylog($branchId,$product,$total,$proQuantity,$inventoryId,$companyId,$userInfo,$uuid);

      }



    alert()->success('Stock Transfered succesfully', 'Success!');
    return redirect("/branchinventory/$frombranchId"); 


  }



  public function reducestock(Request $request){
 
     $validatedData = $request->validate([
        'frombranchId' => 'required', 
        'quantity' => 'required|numeric',
        'productId' => 'required', 
    ]);

    $uuid = Idgenerator();
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $frombranchId=request('frombranchId');
    $quantity=request('quantity');
    $productId=request('productId');

    if(!is_numeric(request('quantity'))){
        alert()->error('Product quantity should be integer', 'Error!');
         return redirect("/branchinventory/$frombranchId");
    }
  
    
     //frombranchId
     $branchId = $frombranchId;
     $Quantity = request('quantity');
     $pquantity = Inventory::select('invQuantity','inventoryId')->where('productId',request('productId'))->where('branchId',$branchId)->first();
 
     $data = json_decode($pquantity);
     $proQuantity= $data->invQuantity;
     $inventoryId=$data->inventoryId;
   
 
 
     if($proQuantity>=$quantity){
 
     $total=$proQuantity-$Quantity;   
     $pro = Inventory::find($inventoryId);
     $pro->invQuantity=$total;
         
     $pro->save();
     $product= request('productId');
 
     inventorylog($branchId,$product,$total,$proQuantity,$inventoryId,$companyId,$userInfo,$uuid);
     
     alert()->success('Stock Reduced succesfully', 'Success!');
     return redirect("/branchinventory/$frombranchId");




    } 

    else{
        alert()->success('Reduction quantity is greater than inventory quantity', 'Error!');
        return redirect("/branchinventory/$frombranchId");

    }




  }

  public function transferstocklog(Request $request){

    $validatedData = $request->validate([
        'from'=>'nullable',
        'to'=>'nullable',
        'warehouseId'=>'nullable',
        'reportType'=>'nullable',
    ]);

    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $branch = Branch::where('companyId',$companyId)->pluck('branchName','branchId');

    if(empty(request('from')) || empty(request('to')) || empty(request('warehouseId')) ){

        $sql="SELECT *,products.name as proname FROM inventorytransferlog inner join products on inventorytransferlog.productId=products.productId inner join branches on branches.branchId=inventorytransferlog.frombranchId inner join users on users.id=inventorytransferlog.userId ORDER BY dateCreated DESC LIMIT 50 ";
        $details =DB::select(DB::raw($sql));
        return view('pos.stocktransfer',compact('details','branch'));

    }
    else{

        $datefrom = date("Y-m-d", strtotime(request('from')));  
        $dateto = date("Y-m-d", strtotime(request('to')));
        $companyId = getusercompanyId();    
        $userInfo = Auth::user()->id;
        $branch=request('warehouseId');
        $from=request('from');
        $to=request('to');
        $reportType=request('reportType');


        if($branch=="All"){
            $sql="SELECT *,products.name as proname FROM `inventorytransferlog` inner join products on inventorytransferlog.productId=products.productId inner join branches on branches.branchId=inventorytransferlog.frombranchId inner join users on users.id=inventorytransferlog.userId where inventorytransferlog.dateCreated between '$datefrom' and '$dateto' ORDER BY dateCreated DESC LIMIT 50  ";

        }

        else{
            $sql="SELECT *,products.name as proname FROM `inventorytransferlog` inner join products on inventorytransferlog.productId=products.productId inner join branches on branches.branchId=inventorytransferlog.frombranchId inner join users on users.id=inventorytransferlog.userId where inventorytransferlog.dateCreated between '$datefrom' and '$dateto' and inventorytransferlog.frombranchId='$branch' ORDER BY dateCreated DESC ";

        }

        
        
        $details =DB::select(DB::raw($sql));
        
        if($reportType=="Web"){
        
        return view('pos.stocktransfer',compact('details','branch'));
        }
        else{


        
            return view('pos.stocktransfer',compact('details','branch')); 
            //return Excel::download(new ExportInventoryLog($details),"InventoryLog.xlsx");
           
        }
    
  
    }


  }





  public function clientinfo(Request $request){
  
  $cartdata =DB::table('clients')->where('clients.phoneNumber','0545444248')->get();
  $count=count($cartdata);
  return Response::json($cartdata);


  }


















}