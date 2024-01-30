<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use \Carbon\Carbon;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use App\Models\AccountsTransaction;
use App\Models\Accounts;
use App\Models\Debt;
use Illuminate\Support\Facades\Auth;
use PDF;

class AccountController extends Controller
{
 public function allAccounts() 
    {

        $usertype=getusertypeInfo();
        $branchId=getuserbranchId();

        if($usertype=="Admin"){

         $companyId = getusercompanyId();
         $accounts = DB::table('accounts')->where('companyId',$companyId)->get(); 
         return view('finance.accounts.index')->with('records',$accounts);

        }

        if($usertype=="SubAdmin"){

         $companyId = getusercompanyId();
         $accounts = DB::table('accounts')->where('companyId',$companyId)->get(); 
         return view('finance.accounts.index')->with('records',$accounts);

        }

        if($usertype=="none"){

            $companyId = getusercompanyId();
            $accounts = DB::table('accounts')->where('companyId',$companyId)->get(); 
            return view('finance.accounts.index')->with('records',$accounts);
   
        }

}


    public function addAccount() 
   {   
    return view('finance.accounts.add');
   
   }

    
   public function editAccount(Accounts $accountId){
   
    $category = Accounts::where('companyId',$accountId)->get();
    return view('finance.accounts.edit',[
        'user' => $accountId, 
    ]);
    }


public function updateAccount(Accounts $accountId, Request $request ){

    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'accountId' => 'required',
    ]);
    $accountId->update([
            'name' =>  request('name'),
            'description'=>request('description'),

        ]);
    alert()->success('Account Updated succesfully', 'Success!');
    return redirect('/allAccounts');
}


public function AccountsStore(Request $request) 
{
    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',   
    ]);

    $branchId=getuserbranchId();
    $uuid = Idgenerator();  // Str::uuid()->toString();
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $mytime = Carbon::now();
    
    $uuid = Str::uuid()->toString();
    $client = new Accounts();
    $client->name = request('name');
    $client->description = request('description');
    $client->companyId = getusercompanyId();
    $client->accountId = $uuid;
    $client->createdBy = $userInfo;
    $client->accdateCreated = $mytime->toDateTimeString();
    $client->save();
    alert()->success('New account added succesfully', 'Success!');
    return redirect('/allAccounts');
}



public function allAccountTransactions() 
{
 $usertype=getusertypeInfo();
 $branchId=getuserbranchId();



 //$sql="SELECT  ";
 //$accountbrkdown= DB::select($sql);

 if($usertype=="Admin"){
 $companyId = getusercompanyId();
 $products = DB::table('account_transactions')->join('accounts', 'accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->where('accounts.companyId',$companyId)->orderBy('account_transactions.created_at','DESC')->get(); 
 $category = Accounts::where('companyId',$companyId)->get();
 $branches = DB::table('branches')->where('companyId',$companyId)->get(); 
 $data = array(
            'accounts'=>$category,
            'transactions'=>$products,
            'branches'=>$branches);
  return view('finance.accounts.transactions')->with($data);

}


if($usertype=="SubAdmin"){
$companyId = getusercompanyId();
$products = DB::table('account_transactions')->join('accounts', 'accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->where('accounts.companyId',$companyId)->orderBy('account_transactions.created_at','DESC')->get(); 
$category = Accounts::where('companyId',$companyId)->get();
$branches = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get(); 
$data = array(
           'accounts'=>$category,
           'transactions'=>$products,
           '$branches'=>$branches,
       );
 return view('finance.accounts.transactions')->with($data);

}

if($usertype=="none"){
    $companyId = getusercompanyId();
    $products = DB::table('account_transactions')->join('accounts', 'accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->where('accounts.companyId',$companyId)->orderBy('account_transactions.created_at','DESC')->get(); 
    $category = Accounts::where('companyId',$companyId)->get();
    $branches = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get(); 
    $data = array(
           'accounts'=>$category,
           'transactions'=>$products,
           'branches'=>$branches,
       );
  return view('finance.accounts.transactions')->with($data);
}

}


public function addAccountTransaction() 
{   
    return view('finance.accounts.addtransactions');
}

    
   public function editAccountTransaction(AccountsTransaction $transactionId){
   
    $usertype=getusertypeInfo();
    $branchId=getuserbranchId();
    $companyId = getusercompanyId();
    $category = Accounts::where('companyId',getusercompanyId())->get();

    if($usertype=="Admin"){
    
      $branches = DB::table('branches')->where('companyId',$companyId)->get(); 
    
       }
       
       
       if($usertype=="SubAdmin"){
    
       $branches = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get(); 
       
       
       }
       
       if($usertype=="none"){
           $branches = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get(); 
         
       }


    return view('finance.accounts.editTransaction',[
        'user' => $transactionId,
        'accounts'=>$category,
        'branches'=>$branches
      
    ]);
    }


public function updateAccountTransaction(AccountsTransaction $transactionId, Request $request ){

    $validatedData = $request->validate([
        'accountId' => 'required',
        'description' => 'required',  
        'amount' => 'required|numeric',
        'transType' =>'required',
        'branchId' =>'required',
        'transactionId'=>'required',
    ]);

    $transactionId->update([
            'accountId' => request('accountId'),
             'transDescription' => request('description'), 
             'amount' => request('amount'),
             'transType' =>request('transType'),
             'branchId' => request('branchId'),
        ]);
    alert()->success('Account Transaction Updated succesfully', 'Success!');
    return redirect('/allAccountTransactions');
}


public function AccountsTransactionStore(Request $request) 
{
    $validatedData = $request->validate([
        'accountId' => 'required',
        'description' => 'required',  
        'amount' => 'required',
        'transType' =>'required',
        'branchId' =>'required',
    ]);

    $userInfo = Auth::user()->id;
    $mytime = Carbon::now();
    $branchId=getuserbranchId();
    $companyId = getusercompanyId();
    $uuid = Str::uuid()->toString();
    $client = new AccountsTransaction();
    $client->transDescription = request('description');
    $client->companyId = getusercompanyId();
    $client->branchId = request('branchId');
    $client->accountTransactionsId =$uuid; 
    $client->amount = request('amount');
    $client->accountId = request('accountId');
    $client->transType = request('transType');
    $client->createdBy = $userInfo;
    $client->dateCreated = $mytime->toDateTimeString();
    $client->save();
    alert()->success('New Transaction added succesfully', 'Success!');
    return redirect('/allAccountTransactions');
}



public function TransactionsByAccount($id) 
{

 $accountId=$id;
 $usertype=getusertypeInfo();
 $branchId=getuserbranchId();


 $companyId = getusercompanyId();
 $products = DB::table('account_transactions')->join('accounts', 'accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->where('accounts.companyId',$companyId)->where('accounts.accountId',$accountId)->orderBy('account_transactions.created_at','DESC')->get(); 
 $category = Accounts::where('companyId',$companyId)->get();
 $branches = DB::table('branches')->where('companyId',$companyId)->get(); 
 $data = array(
            'accounts'=>$category,
            'transactions'=>$products,
            'branches'=>$branches
        );
  return view('finance.accounts.transactions')->with($data);



}


public function accountTransactionReport(Request $request) {

$validatedData = $request->validate([
    'from'=>'required',
    'to'=>'required',
    'accountId'=>'required',
    'transType'=>'required',
    'branchId'=>'required',
    'reportType'=>'required',
]);
$companyId = getusercompanyId();    
$userInfo = Auth::user()->id;
$accounts = Accounts::where('companyId',$companyId)->get();
$branches = DB::table('branches')->where('companyId',$companyId)->get(); 
$data = array(
           'accounts'=>$accounts,
           'branches'=>$branches
       );

if(!empty(request('from')) || !empty(request('to')) || !empty(request('accountId')) || !empty(request('transType')) || !empty(request('branchId'))){
 

 $from=date("Y-m-d", strtotime(request('from')));
 $to=date("Y-m-d", strtotime(request('to')));
 $accountId=request('accountId');
 $transType=request('transType');
 $branchId=request('branchId');
 $reportType=request('reportType');


if($accountId=="All" && $branchId=="All"){

$transactions = DB::table('account_transactions')->join('accounts', 'accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('account_transactions.created_at',[$from,$to])->where('accounts.companyId',$companyId)->orderBy('account_transactions.created_at','DESC')->get(); 


if($reportType=='webview'){
return view('finance.accounts.transactions',compact('transactions','accounts','branches'));
}



else{

    $data = [

        'transactions' => $transactions

    ];

    $pdf = PDF::loadView('finance.accounts.transactions-pdf',$data)->setOptions(['defaultFont' => 'sans-serif']);
    return $pdf->download('itsolutionstuff.pdf');

}

}


if($accountId=="All" && $branchId!="All"){

$transactions = DB::table('account_transactions')->join('accounts','accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('account_transactions.created_at',[$from,$to])->where('accounts.companyId',$companyId)->where('account_transactions.branchId',$branchId)->orderBy('account_transactions.created_at','DESC')->get(); 
return view('finance.accounts.transactions',compact('transactions','accounts','branches'));
}

if($accountId!="All" && $branchId=="All"){

$transactions = DB::table('account_transactions')->join('accounts','accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('account_transactions.created_at',[$from,$to])->where('accounts.companyId',$companyId)->where('account_transactions.accountId',$accountId)->orderBy('account_transactions.created_at','DESC')->get(); 
return view('finance.accounts.transactions',compact('transactions','accounts','branches'));

}

else{

$transactions = DB::table('account_transactions')->join('accounts','accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('account_transactions.created_at',[$from,$to])->where('accounts.companyId',$companyId)->where('account_transactions.accountId',$accountId)->where('account_transactions.branchId',$branchId)->orderBy('account_transactions.created_at','DESC')->get(); 
return view('finance.accounts.transactions',compact('transactions','accounts','branches'));

  }


}

else{

    alert()->error('Required parameters', 'Error!');
    return redirect('/allAccountTransactions');

}



}




public function allDebt() 
    {

        $usertype=getusertypeInfo();
        $branchId=getuserbranchId();

        if($usertype=="Admin"){

         $companyId = getusercompanyId();
         $branches = DB::table('branches')->where('companyId',$companyId)->get();
         $debt = DB::table('debt')->join('branches', 'branches.branchId', '=', 'debt.branchId')->where('debt.companyId',$companyId)->orderBy('debt.created_at','DESC')->get(); 
         
         $data = array(
            'branches'=>$branches,
            'record'=>$debt,
        );
         return view('finance.debt.index')->with($data);

        }

        if($usertype=="SubAdmin"){

         $companyId = getusercompanyId();
         $branches = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get();
         $debt = DB::table('debt')->join('branches', 'branches.branchId', '=', 'debt.branchId')->where('debt.companyId',$companyId)->where('debt.branchId',$branchId)->orderBy('debt.created_at','DESC')->get(); 
         $data = array(
            'branches'=>$branches,
            'record'=>$debt,
        );
         return view('finance.debt.index')->with($data);

        }

        if($usertype=="none"){

         $companyId = getusercompanyId();
         $branches = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get();
         $debt = DB::table('debt')->join('branches', 'branches.branchId', '=', 'debt.branchId')->where('debt.companyId',$companyId)->where('debt.branchId',$branchId)->orderBy('debt.created_at','DESC')->get(); 
         $data = array(
            'branches'=>$branches,
            'record'=>$debt,
        );
         return view('finance.debt.index')->with($data);
   
        }

}

       public function addDebt() 
      {   
      return view('finance.debt.add');
      }

    
   public function editDebt(Debt $debtId){
    $companyId = getusercompanyId();
    $usertype=getusertypeInfo();
    $branchId=getuserbranchId();
    $category = Debt::where('companyId',$debtId)->get();

    if($usertype=="Admin"){
        $branches = DB::table('branches')->where('companyId',$companyId)->get(); 
    }

    if($usertype=="SubAdmin"){
         $branches = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get(); 
    }
         
    if($usertype=="none"){
             $branches = DB::table('branches')->where('companyId',$companyId)->where('branchId',$branchId)->get(); 
    }
    return view('finance.debt.edit', [
        'user' => $debtId,
        'branches'=>$branches, 
    ]);
    
}


public function updateDebt(Debt $debtId, Request $request ){
    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'amountOwed' => 'required', 
        'branchId' => 'required', 
        'amountPaid' => 'required',
        'debtId' => 'required',
        'status' => 'required',
    ]);
    $debtId->update([
            'name' =>  request('name'),
            'description'=>request('description'),
            'amountOwed'=>request('amountOwed'),
            'branchId'=>request('branchId'),
            'amountPaid'=>request('amountPaid'),
            'status'=>request('status'),

        ]);
    alert()->success('Debt Updated succesfully', 'Success!');
    return redirect('/allDebt');
}


public function DebtStore(Request $request) 
{
   $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'amountOwed' => 'required', 
        'branchId' => 'required', 
        'amountPaid' => 'required', 
    ]);
    $branchId=getuserbranchId();
    $uuid = Idgenerator();  // Str::uuid()->toString();
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $mytime = Carbon::now();
    $uuid = Str::uuid()->toString();
    $client = new Debt();
    $client->name = request('name');
    $client->description = request('description');
    $client->companyId = getusercompanyId();
    $client->debtId = $uuid;
    $client->createdBy = $userInfo;
    $client->dateCreated = $mytime->toDateTimeString();
    $client->amountOwed = request('amountOwed');
    $client->branchId = request('branchId');
    $client->status ='unpaid';
    $client->amountPaid = request('amountPaid');
    $client->save();
    alert()->success('New Debt added succesfully', 'Success!');
    return redirect('/allDebt');
}


public function debtReport(Request $request){
    $validatedData = $request->validate([
        'from'=>'required',
        'to'=>'required',
        'status'=>'required',
        'branchId'=>'required',
        'reportType'=>'required',
    ]);
    $companyId = getusercompanyId();    
    $userInfo = Auth::user()->id;
    $accounts = Accounts::where('companyId',$companyId)->get();
    $branches = DB::table('branches')->where('companyId',$companyId)->get(); 
    $data = array(
               'accounts'=>$accounts,
               'branches'=>$branches
           );
    
    if(!empty(request('from')) || !empty(request('to')) || !empty(request('accountId')) || !empty(request('transType')) || !empty(request('branchId'))){
     
    
     $from=date("Y-m-d", strtotime(request('from')));
     $to=date("Y-m-d", strtotime(request('to')));
     $status=request('status');
     $branchId=request('branchId');
     $reportType=request('reportType');
    
    
    if($status=="All" && $branchId=="All"){
    
    $debt = DB::table('debt')->join('branches', 'branches.branchId', '=','debt.branchId')->where('debt.companyId',$companyId)->where('debt.branchId',$branchId) ->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('debt.created_at',[$from,$to])->orderBy('debt.created_at','DESC')->get(); 
    if($reportType=='webview'){
    return view('finance.accounts.transactions',compact('debt'));
    }

    else{
    $data = [
    
            'transactions' => $debt
    
        ];
    
        $pdf = PDF::loadView('finance.accounts.transactions-pdf',$data)->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('itsolutionstuff.pdf');
    
    }
    
    }
    
    
    if($status=="All" && $branchId!="All"){
    $debt = DB::table('debt')->join('branches', 'branches.branchId', '=','debt.branchId')->where('debt.companyId',$companyId)->where('debt.branchId',$branchId) ->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('debt.created_at',[$from,$to])->orderBy('debt.created_at','DESC')->get();
    $transactions = DB::table('account_transactions')->join('accounts','accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('account_transactions.created_at',[$from,$to])->where('accounts.companyId',$companyId)->where('account_transactions.branchId',$branchId)->orderBy('account_transactions.created_at','DESC')->get(); 
    return view('finance.accounts.transactions',compact('debt'));
    }
    
    if($status!="All" && $branchId=="All"){
    
    $transactions = DB::table('account_transactions')->join('accounts','accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('account_transactions.created_at',[$from,$to])->where('accounts.companyId',$companyId)->where('account_transactions.accountId',$accountId)->orderBy('account_transactions.created_at','DESC')->get(); 
    return view('finance.accounts.transactions',compact('debt'));
    
    }
    
    else{
    
    $transactions = DB::table('account_transactions')->join('accounts','accounts.accountId', '=', 'account_transactions.accountId')->join('branches', 'branches.branchId', '=', 'account_transactions.branchId')->whereBetween('account_transactions.created_at',[$from,$to])->where('accounts.companyId',$companyId)->where('account_transactions.accountId',$accountId)->where('account_transactions.branchId',$branchId)->orderBy('account_transactions.created_at','DESC')->get(); 
    return view('finance.accounts.transactions',compact('debt'));
    
      }
    
    
    }
    
    else{
    
        alert()->error('Required parameters', 'Error!');
        return redirect('/allAccountTransactions');
    
    }

}



}
