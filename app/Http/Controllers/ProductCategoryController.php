<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\ProductsCategory;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
   
    public function allcategory() 
    {
    $companyId = getusercompanyId();
    $products = DB::table('productscategory')->where('productscategory.companyId',$companyId)->get();  
    return view('procategory.index')->with('records',$products);
    }


    public function addproductcategory() 
   {
    return view('procategory.add');
  
   }


   
public function editproductcategory(ProductsCategory $categoryId){
    $companyId = getusercompanyId();
    $category = ProductsCategory::where('companyId', $companyId)->get();
    return view('procategory.edit', [
        'user' => $categoryId,
        'countries'=>$category
      
    ]);
}


public function updateproductcategory(ProductsCategory $productId, Request $request ){
    //$confirmimage = $request->confirmPic;


     
    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        
    ]);


    if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);
        $productId->update([
            'catName' =>  request('name'),
            'details' => request('description'),
            'catPic' =>$imageName,
        ]);

    }
    else{
       
        $productId->update([
            'catName' =>  request('name'),
            'details' => request('description'),
         
        ]);

    }

    alert()->success('Product category Updated succesfully', 'Success!');

    return redirect('/allcategory');
}


public function productcategorystore(Request $request) 
{
   $validatedData = $request->validate([
        'name' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        'description' => 'required',
        
    ]);


    if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);
        $mytime = Carbon::now();
        $uuid = Str::uuid()->toString();
        $client = new ProductsCategory();
        $client->catName = request('name');
        $client->details = request('description');
        $client->categoryId = $uuid;
        $client->date = $mytime->toDateTimeString();
        $client->catPic =$imageName;
        $client->companyId = getusercompanyId();
        $client->save();
    
       alert()->success('New product category Added succesfully', 'Success!');
    
       return redirect('/allcategory');

    }

    else{

      
        $mytime = Carbon::now();
        $uuid = Str::uuid()->toString();
        $client = new ProductsCategory();
        $client->catName = request('name');
        $client->details = request('description');
        $client->categoryId = $uuid;
        $client->date = $mytime->toDateTimeString();
        $client->catPic ="";
        $client->companyId = getusercompanyId();
        $client->save();
    
       alert()->success('New product category Added succesfully', 'Success!');
    
       return redirect('/allcategory');
    }
 
}


}
