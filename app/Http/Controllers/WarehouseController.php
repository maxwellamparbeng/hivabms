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
use Illuminate\Support\Facades\App;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Employee;
use App\Models\Warehouse;
use App\Models\WarehouseInventory;
use App\Models\Inventory;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Exports\ExportWarehouseInventory;
use App\Exports\ExportWarehouseInventoryLog;
 




class WarehouseController extends Controller
{
    public function allwarehouses() 
    {

        $usertype=getusertypeInfo();
        $branchId=getuserbranchId();

        if($usertype=="Admin"){

         $companyId = getusercompanyId();
         $products = DB::table('warehouse')->where('companyId',$companyId)->get(); 
         return view('warehouse.index')->with('records',$products);

        }


        if($usertype=="SubAdmin"){

         $companyId = getusercompanyId();
         $products = DB::table('warehouse')->where('companyId',$companyId)->get(); 
         return view('warehouse.index')->with('records',$products);

        }

          if($usertype=="none"){

            $companyId = getusercompanyId();
            $products = DB::table('warehouse')->where('companyId',$companyId)->get(); 
            return view('warehouse.index')->with('records',$products);
   
           }

        else{

          
            $products = DB::table('warehouse')->get(); 
            return view('warehouse.index')->with('records',$products);

        }

}


public function addwarehouse() 
{   
    return view('warehouse.add');

}


public function editwarehouse(Warehouse $warehouseId){
   // $companyId = getusercompanyId();
    $category = Warehouse::where('warehouseId', $warehouseId)->get();
    return view('warehouse.edit', [
        'user' => $warehouseId,   
]);
}


public function updatewarehouse(Warehouse $warehouseId, Request $request ){

$validatedData = $request->validate([
        'name' => 'required|required|regex:/^([^0-9]*)$/',
        'phone' => 'required|numeric',
        'location' => 'required',    
    ]);
   

$warehouseId->update([
            'warehouseName' =>  request('name'),
            'warehousePhone'=>request('phone'),
            'location'=>request('location'),
         
]);

alert()->success('Warehouse Updated succesfully', 'Success!');
return redirect('/allwarehouses');
}


public function storewarehouse(Request $request) 
{
      $validatedData = $request->validate([
        'name' => 'required|required|regex:/^([^0-9]*)$/',
        'phone' => 'required|numeric',
        'location' => 'required',

        
    ]);

    $uuid = Str::uuid()->toString();
    $client = new Warehouse();
    $client->warehouseName = request('name');
    $client->warehousePhone = request('phone');
    $client->location = request('location');
    $client->companyId = getusercompanyId();
    $client->warehouseId = $uuid;
    $client->save();

   alert()->success('New Warehouse Added succesfully', 'Success!');

    return redirect('/allwarehouses');
}




public function warehouseinventory($id) 
{
    productadditiontowarehousestock();
    $branch=$id;
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->join('warehouseinventory', 'warehouseinventory.productId', '=', 'products.productId')->where('products.companyId',$companyId)->where('warehouseinventory.warehouseId',$id)->paginate(200);  
    $type='warehouse';
    $branches=getbranchforstocktransfer($id,$type);
    return view('warehouse.warehouseinventory',compact('products','branch','branches'));   



}



public function exportwarehouseinventory($id) 
{
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
  
    $sql="SELECT * FROM `warehouseinventory` inner join products on warehouseinventory.productId=products.productId where warehouseinventory.warehouseId='$id' and warehouseinventory.companyId='$companyId' ";

     $details =DB::select(DB::raw($sql));
     return Excel::download(new ExportWarehouseInventory($details),"Inventory.xlsx");

}


public function exportwarehouseinventorylog(Request $request) 
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

$sql="SELECT * FROM `inventorylog` inner join products on inventorylog.productId=products.productId  where dateCreated between '$datefrom' and '$dateto' and inventorylog.branchId='$branch'";

 $details =DB::select(DB::raw($sql));
 return Excel::download(new ExportWarehouseInventoryLog($details),"InventoryLog.xlsx");

}


public function reducewarehousestock(Request $request){
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
         return redirect("/$frombranchId/warehouseinventory/");
    }
  
    
     //frombranchId
     $branchId = $frombranchId;
     $Quantity = request('quantity');
     $pquantity = WarehouseInventory::select('invQuantity','inventoryId')->where('productId',request('productId'))->where('warehouseId',$branchId)->first();
 
     $data = json_decode($pquantity);
     $proQuantity= $data->invQuantity;
     $inventoryId=$data->inventoryId;
   
     if($proQuantity>=$quantity){
 
     $total=$proQuantity-$Quantity;   
     $pro = WarehouseInventory::find($inventoryId);
     $pro->invQuantity=$total;
         
     $pro->save();
     $product= request('productId');
 
     inventorylog($branchId,$product,$total,$proQuantity,$inventoryId,$companyId,$userInfo,$uuid);
     
     alert()->success('Stock Reduced succesfully', 'Success!');

     return redirect("/$frombranchId/warehouseinventory/"); 

    } 

    else{
        alert()->success('Reduction quantity is greater than inventory quantity', 'Error!');
        return redirect("/$frombranchId/warehouseinventory/");

    }



}


public function transferwarehousestock(Request $request){

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
         return redirect("/warehouseinventory/$frombranchId");
    }


    //frombranchId
    $branchId = $frombranchId;

   
    $Quantity = request('quantity');
    $pquantity = WarehouseInventory::select('invQuantity','inventoryId')->where('productId',request('productId'))->where('warehouseId',$branchId)->first();

    
    $data = json_decode($pquantity);
    $proQuantity= $data->invQuantity;
    $inventoryId=$data->inventoryId;
   


    if($proQuantity>=$quantity){


    $transferType='2';
    $userId=$userInfo;

    stocktransferlog($frombranchId,$productId,$tobranchId,$userId,$quantity,$companyId,$transferType);


    $total=$proQuantity-$Quantity;   
    $pro = WarehouseInventory::find($inventoryId);
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
    return redirect("/$frombranchId/warehouseinventory/"); 
    
}


public function updatewarehouseinventory(Request $request){


    $validatedData = $request->validate([
        'product' => 'required',
        'quantity' => 'required|numeric',
        'branchId'=>'required'
        
    ]
);


    if(!is_numeric(request('quantity'))){
        alert()->error('Product quantity should be integer', 'Error!');
        $branchId = request('branchId');
        return redirect("/$branchId/warehouseinventory/"); 
    }
    $uuid = Idgenerator();
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $branchId = request('branchId');
    $Quantity = request('quantity');
    $pquantity = WarehouseInventory::select('invQuantity','inventoryId')->where('productId',request('product'))->where('warehouseId',request('branchId'))->first();
    $data = json_decode($pquantity);
    $proQuantity= $data->invQuantity;
    $total=$proQuantity+$Quantity;
    $inventoryId=$data->inventoryId;
   
    if(is_numeric($total)){
        $pro = WarehouseInventory::find($inventoryId);
        $pro->invQuantity=$total;
        
        $pro->save();

          $product= request('product');
          inventorylog($branchId,$product,$total,$proQuantity,$inventoryId,$companyId,$userInfo,$uuid);
    
    }
    
    alert()->success('Product Quantity Updated succesfully', 'Success!');
    return redirect("/$branchId/warehouseinventory/"); 


    
}
         
         

public function warehousetransferstocklog(Request $request){

    $validatedData = $request->validate([
        'from'=>'nullable',
        'to'=>'nullable',
        'warehouseId'=>'nullable',
        'reportType'=>'nullable',
    ]);

    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $warehouse = Warehouse::where('companyId',$companyId)->pluck('warehouseName','warehouseId');

    if(empty(request('from')) || empty(request('to')) || empty(request('warehouseId')) ){

        $sql="SELECT * FROM `inventorytransferlog` inner join products on inventorytransferlog.productId=products.productId inner join warehouse on warehouse.warehouseId=inventorytransferlog.frombranchId inner join branches on branches.branchId=inventorytransferlog.tobranchId inner join users on users.id=inventorytransferlog.userId ORDER BY dateCreated DESC LIMIT 50  ";
        $details =DB::select(DB::raw($sql));

        return view('warehouse.stocktransfer',compact('details','warehouse'));

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
            $sql="SELECT * FROM `inventorytransferlog` inner join products on inventorytransferlog.productId=products.productId inner join warehouse on warehouse.warehouseId=inventorytransferlog.frombranchId inner join branches on branches.branchId=inventorytransferlog.tobranchId inner join users on users.id=inventorytransferlog.userId where inventorytransferlog.dateCreated between '$datefrom' and '$dateto' ORDER BY dateCreated DESC LIMIT 50  ";

        }

        else{
            $sql="SELECT * FROM `inventorytransferlog` inner join products on inventorytransferlog.productId=products.productId inner join warehouse on warehouse.warehouseId=inventorytransferlog.frombranchId inner join branches on branches.branchId=inventorytransferlog.tobranchId inner join users on users.id=inventorytransferlog.userId where inventorytransferlog.dateCreated between '$datefrom' and '$dateto' and inventorytransferlog.frombranchId='$branch' ORDER BY dateCreated DESC ";

        }

        
        
        $details =DB::select(DB::raw($sql));
        
        if($reportType=="Web"){
        
        return view('warehouse.stocktransfer',compact('details','warehouse'));
        }
        else{
        
            
            return Excel::download(new ExportWarehouseInventoryLog($details),"InventoryLog.xlsx");
           
        }
        
        

    }





    
}


 
 


}
