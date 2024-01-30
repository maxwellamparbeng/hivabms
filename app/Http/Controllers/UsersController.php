<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Company;
use App\Models\Branch;
use Faker\UniqueGenerator;
use Illuminate\Bus\UniqueLock;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {




        //    $role='Super Admin';
        //     $userrole = Auth::user()->role;
        //     $checkrole = explode(',', $userrole);

            
        //     print_r($checkrole);
        //     if (in_array($role, $checkrole)) {
                
        //         echo'money';
        //        // return true;
        //     }
           
        //     echo'no money';

        //     return;

        
        $userInfo = Auth::user()->id;
        //$users = User::where('companyId', $companyId)->latest()->paginate(10);

        if($userInfo==5){

            $users = User::latest()->paginate(10);

            return view('users.index', compact('users'));

        }

        else{
            
            $companyId = getusercompanyId();
            $users = User::where('companyId', $companyId)->latest()->paginate(10);

           return view('users.index', compact('users'));

        }

       


    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        $roles = Role::where('name', '!=','Super Admin')->latest()->get();
        $userInfo = Auth::user()->id;
        if($userInfo==5){
        $company = Company::pluck('companyName','companyId');
        //$userRole = $user->roles->pluck('name')->toArray();
        
        $branch = Branch::pluck('branchName','branchId');
        return view('users.create',compact('company','branch','roles'));
    

        }

        else{


           $usertype=getusertypeInfo();
           $branchId=getuserbranchId();

           if($usertype=="Admin"){

            $companyId = getusercompanyId();
            $company = Company::where('companyId', $companyId)->pluck('companyName','companyId');
            $branch = Branch::where('companyId', $companyId)->pluck('branchName','branchId');
            $roles=Role::where('name', '!=','Super Admin')->where('companyId',$companyId)->latest()->get();
            return view('users.create',compact('company','branch','roles'));

           }


           if($usertype=="SubAdmin"){

            $companyId = getusercompanyId();
            $company = Company::where('companyId', $companyId)->pluck('companyName','companyId');
            $branch = Branch::where('companyId',$companyId)->where('branchId', '=',$branchId)->pluck('branchName','branchId');
            $roles=Role::where('name', '!=','Super Admin')->where('companyId',$companyId)->latest()->get();
            return view('users.create',compact('company','branch','roles'));

           }

           
        }



       
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request) 
    {
        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
      
        $feature="users";
        $data=getCompanySubcriptionDetails($feature);
        if(empty($data)){
        
        }
      elseif(!$data[0]){   
             alert()->error($data[1], 'Error!');
             return redirect($data[2]);
             }
      
      
        $lenghth=12;
       $pass= passgenerator($lenghth);
        $user->create(array_merge($request->validated(), [
            'password' =>$pass,
             'companyId'=>$request->companyId,
             'branchId'=>$request->branchId,
             'userType'=>$request->userType
        ]));

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully with new password is '.$pass.'  '));
    }

    /**
     * Show user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) 
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) 
    {

        //print_r(Role::where('name', '!=','Super Admin')->latest()->get());
       
       $userId = Auth::user()->id; 
       
       
        if($userId==5){

            $branch = Branch::where('companyId',$companyId)->pluck('branchName','branchId');
         
        return view('users.edit',[
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::where('name', '!=','Super Admin')->latest()->get(),
            'branches'=>$branch,
        ]);

        }
       
       
       
    //   if($user->id!=$userId){
           
    //     return redirect()->route('users.index')
    //         ->withSuccess(__('Cannot update or view user record'));
       
           
    //   }
       

       $usertype=getusertypeInfo();
       $branchId=getuserbranchId();
       $companyId = getusercompanyId();
       $branch = Branch::where('companyId',$companyId)->pluck('branchName','branchId');
      
       
       return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::where('name', '!=','Super Admin')->where('companyId',$companyId)->latest()->get(),
            'branches'=>$branch,
        ]);
       
        
        
      

     
    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UpdateUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request) 
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) 
    {
       // $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User cannot be deleted.'));
    }

    // /** * Show records * * @return \Illuminate\Http\Response */ 
    
    public function dropDownShow(Request $request) 
    { $products = Product::pluck('name', 'id'); $selectedID = 2; 
        
        return view('products.edit', compact('id', 'products')); 
    
    }

    public function allcompany(User $user) 
    {

     $company = Company::all();
     return view('booking.bookings',compact('id', $company));
       
    }

    

    public function updatepassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
      ]);

      $companyId = getusercompanyId();    
      $userId = Auth::user()->id;

      $password=  request('password');
      
      
      $user = DB::table('users')->where('id',$userId)->first(); 
      $userId=$user->id;
     $user = User::find($userId);
     

      $user->password =$password;
      $user->save();

      return redirect()->route('users.index')
      ->withSuccess(__('Your password has been changed  succesfully'));
    }

    public function resetpassword($id)
    {
    
     $checkdata=userchecker($id);

     if($checkdata>0){
        $userId=  $id; 
        $password=  request('newpassword'); 
        $user = DB::table('users')->where('id',$userId)->first(); 
        $userId=$user->id;
        $user = User::find($userId);
        $lenghth=12;
        $pass= passgenerator($lenghth);
        $credential=$pass;
        $user->password= $credential;  // =Hash::make($credential);
        $user->save();

        return redirect()->route('users.index')
        ->withSuccess(__('User password has been resetted succesfully. New password is . '.$credential.''));

     }
     else{
        return redirect()->route('users.index')
        ->withError(__('User password cannot be resetted. Try again later '));

     }
   
    }

  








}


/*

git clone https://github.com/codeanddeploy/laravel8-authentication-example.git

if your using my previous tutorial navigate your project folder and run composer update



install packages

composer require spatie/laravel-permission
composer require laravelcollective/html

then run php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

php artisan migrate

php artisan make:migration create_posts_table

php artisan migrate

models
php artisan make:model Post

middleware
- create custom middleware
php artisan make:middleware PermissionMiddleware

register middleware
- 

routes

controllers

- php artisan make:controller UsersController
- php artisan make:controller PostsController
- php artisan make:controller RolesController
- php artisan make:controller PermissionsController

requests
- php artisan make:request StoreUserRequest
- php artisan make:request UpdateUserRequest

blade files

create command to lookup all routes
- php artisan make:command CreateRoutePermissionsCommand
- php artisan permission:create-permission-routes

seeder for default roles and create admin user
php artisan make:seeder CreateAdminUserSeeder
php artisan db:seed --class=CreateAdminUserSeeder



*/