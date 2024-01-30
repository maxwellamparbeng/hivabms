<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\ProductsCategory;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportProducts;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
   
    public function allproducts() 
    {
     $products = Product::all();
    $companyId = getusercompanyId();
    $products = DB::table('products')->join('productscategory', 'products.catId', '=', 'productscategory.categoryId')->where('products.companyId',$companyId)->paginate(200);  
    return view('product.index')->with('records',$products);

    }
    
   public function addproduct() 
   {
    $companyId = getusercompanyId();
    $category = ProductsCategory::where('companyId', $companyId)->get();
    $countries = $category ;
    return view('product.add', compact('countries'));
   }


   
    public function editproduct(Product $productId){
    $companyId = getusercompanyId();
    $category = ProductsCategory::where('companyId', $companyId)->get();
    return view('product.edit', [
        'user' => $productId,
        'countries'=>$category
      
     ]);
}


public function updateproduct(Product $productId, Request $request ){
    
    $confirmimage = $request->confirmPic;

    if($request->hasFile('image')){

        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'Status' => 'required',
            'price' => 'nullable',
            'quantity' => 'nullable',
            'cprice'=>'nullable',
            'bwhprice'=>'nullable',
            'whprice'=>'nullable',
            'pbwhprice'=>'nullable',
            'rprice'=>'nullable',
            'prprice'=>'nullable', 
            'barcodeinput'=>'nullable',  
        ]);

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('storage'), $imageName);
        $productId->update([
            'name' =>  request('name'),
            'description' => request('description'),
            'Status' => request('Status'),
            'catId' => request('category'),
            'price' => request('price'),
            'quantity' => request('quantity'),
            'pic' =>$imageName,
            'cprice'=>request('cprice'),
            'whprice'=>request('whprice'),
            'bwhprice'=>request('bwhprice'),
            'pbwhprice'=>request('pbwhprice'),
            'rprice'=>request('rprice'),
            'prprice'=>request('prprice'),
            'barcode'=>request('barcodeinput'),
        ]);

    }
    else{

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'Status' => 'required',
            'price' => 'nullable',
            'category'=>'required',
            'cprice'=>'required',
            'bwhprice'=>'required',
            'whprice'=>'required',
            'pbwhprice'=>'required',
            'rprice'=>'required',
            'prprice'=>'required',
            'barcodeinput'=>'nullable', 
            
        ]);

        $productId->update([
            'name' =>  request('name'),
            'description' => request('description'),
            'Status' => request('Status'),
            'catId' => request('category'),
            'price' => request('price'),
            'cprice'=>request('cprice'),
            'whprice'=>request('whprice'),
            'bwhprice'=>request('bwhprice'),
            'pbwhprice'=>request('pbwhprice'),
            'rprice'=>request('rprice'),
            'prprice'=>request('prprice'),
            'barcode'=>request('barcodeinput'),
        ]);
    }
    alert()->success('Product Updated succesfully', 'Success!');
    return redirect('/allproducts');

}


public function productstore(Request $request) 
{

    if($request->hasFile('image')){
        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'Status' => 'required',
            'price' => 'nullable',
            'quantity' => 'nullable',
            'cprice'=>'required',
            'bwhprice'=>'required',
            'whprice'=>'required',
            'pbwhprice'=>'required',
            'rprice'=>'required',
            'prprice'=>'required', 
            'barcodeinput'=>'nullable', 
            'category'=>'required',
            
        ]);
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('storage'), $imageName);
        $mytime = Carbon::now();
        $uuid = Str::uuid()->toString();
        $client = new Product();
        $client->name = request('name');
        $client->description = request('description');
        $client->Status = request('Status');
        $client->price = request('price');
        $client->catId = request('category');
        $client->date = $mytime->toDateTimeString();
        $client->productId = $uuid;
        $client->supplier ='';
        $client->unit ='';
        $client->qty =0;
        $client->pic =$imageName;
        $client->company='';
        $client->expdate='';
        $client->companyId = getusercompanyId();
        $client->qty= request('quantity');
        $client->cprice=request('cprice');
        $client->whprice=request('whprice');
        $client->bwhprice=request('bwhprice');
        $client->pbwhprice=request('pbwhprice');
        $client->rprice=request('rprice');
        $client->prprice=request('prprice');
        $client->barcode=request('barcodeinput');
        $client->save();
    
        alert()->success('New product Added succesfully', 'Success!');
    
        return redirect('/allproducts');

    }

    else{

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'Status' => 'required',
            'price' => 'nullable',
            'quantity' => 'nullable',
            'cprice'=>'required',
            'bwhprice'=>'required',
            'whprice'=>'required',
            'pbwhprice'=>'required',
            'rprice'=>'required',
            'prprice'=>'required', 
            'barcodeinput'=>'nullable', 
            
        ]);
        $mytime = Carbon::now();
        $uuid = Str::uuid()->toString();
        $client = new Product();
        $client->name = request('name');
        $client->description = request('description');
        $client->Status = request('Status');
        $client->price = request('price');
        $client->catId = request('category');
        $client->date = $mytime->toDateTimeString();
        $client->productId = $uuid;
        $client->supplier ='1234';
        $client->unit ='';
        $client->pic ='';
        $client->company='';
        $client->expdate='';
        $client->companyId = getusercompanyId();
        $client->cprice=request('cprice');
        $client->whprice=request('whprice');
        $client->bwhprice=request('bwhprice');
        $client->pbwhprice=request('pbwhprice');
        $client->rprice=request('rprice');
        $client->prprice=request('prprice');
        $client->barcode=request('barcodeinput');
        $client->save();
    
        alert()->success('New product Added succesfully', 'Success!');
    
        return redirect('/allproducts');


    }


}




public function exportProduct()
{


$details= DB::table('products')->get();
return Excel::download(new ExportProducts($details), 'Products.xlsx');


}



public function deleteProduct($id)
{

$sql="select * from transaction_details where productId='$id'" ;
$cartdata =  DB::select(DB::raw($sql));
$count=count($cartdata);
if($count>0){
alert()->error('Product cannot be deleted at the moment succesfully', 'Error!');
return redirect('/allproducts');
}

else{
DB::table('products')->where('productId', $id)->delete();
alert()->success('Product deleted succesfully', 'Success!');

return redirect('/allproducts');
}


}





}
