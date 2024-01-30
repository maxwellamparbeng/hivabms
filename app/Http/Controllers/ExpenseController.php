<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Models\ExpenseCategory;

class ExpenseController extends Controller
{
 public function allExpenseCategory() 
    {
        $usertype=getusertypeInfo();
        $branchId=getuserbranchId();
        $companyId = getusercompanyId();
        if($usertype=="Admin"){
         $companyId = getusercompanyId();
         $products = DB::table('expense_category')->where('companyId',$companyId)->get();
         return view('finance.expensecat.index')->with('records',$products);
        }
         if($usertype=="SubAdmin"){
         $products = DB::table('expense_category')->where('companyId',$companyId)->get(); 
         return view('finance.expensecat.index')->with('records',$products);
        }
         if($usertype=="none"){
            $products = DB::table('expense_category')->where('companyId',$companyId)->get(); 
            return view('finance.expensecat.index')->with('records',$products);
        }
        else{
            $products = DB::table('expense_category')->get(); 
            return view('finance.expensecat.index')->with('records',$products);
            }
}


    public function addExpenseCategory() 
   {   
    return view('finance.expensecat.add');
   }

    
   public function editExpenseCategory(ExpenseCategory $expensecategoryId){
   
    $category = ExpenseCategory::where('companyId', $expensecategoryId)->get();
    return view('finance.expensecat.edit', [
        'user' => $expensecategoryId,
      
    ]);
    }


public function updateExpenseCategory(Expense $expensecategoryId, Request $request ){

    $validatedData = $request->validate([
        'name' => 'required|required|regex:/^([^0-9]*)$/',
        'description' => 'required',

        
    ]);
   

    $expensecategoryId->update([
            'expenseName' =>  request('name'),
            'catDescription'=>request('description'),

        ]);
    alert()->success('Expense Category Updated succesfully', 'Success!');
    return redirect('/allexpensecategory');
}


public function expenseCategoryStore(Request $request) 
{
    $validatedData = $request->validate([
        'name' => 'required|required|regex:/^([^0-9]*)$/',
        'description' => 'required',   
    ]);

    $uuid = Str::uuid()->toString();
    $client = new ExpenseCategory();
    $client->expenseCatName = request('name');
    $client->catDescription = request('description');
    $client->companyId = getusercompanyId();
    $client->expenseCategoryId = $uuid;
    $client->save();
    alert()->success('New expense category added succesfully', 'Success!');
    return redirect('/allexpensecategory');
}


public function allExpense() 
{
 $usertype=getusertypeInfo();
 $branchId=getuserbranchId();
 if($usertype=="Admin"){
 $companyId = getusercompanyId();
 $products = DB::table('expense')->join('expense_category', 'expense_category.expenseCategoryId', '=', 'expense.categoryId')->where('expense.companyId',$companyId)->get(); 
 $category = ExpenseCategory::where('companyId',$companyId)->get();
 $branches = DB::table('branches')->join('company','company.companyId','=','branches.companyId')->get(); 
 $data = array(
            'category'=>$category,
            'expense'=>$products,
            'branches'=>$branches,
        );
 return view('finance.expense.index')->with($data);
}
if($usertype=="SubAdmin"){
$companyId = getusercompanyId();
$category = ExpenseCategory::where('companyId',$companyId)->get();
$branches = DB::table('branches')->join('company','company.companyId','=','branches.companyId')->get();
$products = DB::table('expense')->join('expense_category', 'expense_category.expenseCategoryId', '=', 'expense.categoryId')->where('expense.companyId',$companyId)->get(); 
$data = array(
            'category'=>$category,
            'expense'=>$products,
            'branches'=>$branches,);
            
return view('finance.expense.index')->with($data);

}

if($usertype=="none"){
$category = ExpenseCategory::where('companyId',$companyId)->get();
$companyId = getusercompanyId();
$products = DB::table('expense')->join('expense_category', 'expense_category.expenseCategoryId', '=', 'expense.categoryId')->where('expense.companyId',$companyId)->get(); 
$branches = DB::table('branches')->join('company','company.companyId','=','branches.companyId')->get();
$data = array(
    'category'=>$category,
    'expense'=>$products,
    'branches'=>$branches,
);
return view('finance.expense.index')->with($data);
}

else{
$category = ExpenseCategory::where('companyId',$companyId)->get();
$products = DB::table('expense')->join('expense_category', 'expense_category.expenseCategoryId', '=', 'expense.categoryId')->get(); 
$branches = DB::table('branches')->join('company','company.companyId','=','branches.companyId')->get();
$data = array(
    'category'=>$category,
    'expense'=>$products,
    'branches'=>$branches,);
return view('finance.expense.index')->with($data);
}

}


public function addExpense() 
{   
    return view('finance.expense.add');
}

    
   public function editExpense(Expense $expenseId){
   
    $category = ExpenseCategory::where('companyId',getusercompanyId())->get();
    return view('finance.expense.edit', [
        'user' => $expenseId,
        'category'=>$category
      
    ]);
    }


public function updateExpense(Expense $expenseId, Request $request ){

    $validatedData = $request->validate([
        'name' => 'required|required|regex:/^([^0-9]*)$/',
        'description' => 'required',  
        'amount' => 'required',
        'categoryId' => 'required',  
    ]);

    $expenseId->update([
            'expenseName' =>  request('name'),
            'description'=>request('description'),
        ]);
    alert()->success('Expense Updated succesfully', 'Success!');
    return redirect('/allexpense');
}


public function expenseStore(Request $request) 
{
    $validatedData = $request->validate([
        'name' => 'required|required|regex:/^([^0-9]*)$/',
        'amount' => 'required',
        'categoryId' => 'required',   
    ]);

    $branchId=getuserbranchId();
    $companyId = getusercompanyId();
    $uuid = Str::uuid()->toString();
    $client = new Expense();
    $client->expenseName = request('name');
    $client->description = request('description');
    $client->companyId = getusercompanyId();
    $client->branchId = $branchId;
    $client->categoryId = request('categoryId');
    $client->amount = request('amount');
    $client->expenseId = $uuid;
    $client->save();
    alert()->success('New expense  added succesfully', 'Success!');
    return redirect('/allexpense');
}






}
