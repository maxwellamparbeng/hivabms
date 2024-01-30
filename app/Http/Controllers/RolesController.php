<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\User;
use App\Models\RolePermissions;


class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        //$roles = Role::orderBy('id','DESC')->paginate(5);

        $userInfo = Auth::user()->id;
        if($userInfo==5){
            $roles = Role::join('company','company.companyId', '=', 'roles.companyId')->orderBy('id','DESC')->paginate(5);
            return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        }

        else{

           
            $companyId = getusercompanyId();
            $roles = Role::join('company','company.companyId', '=', 'roles.companyId')->where('roles.companyId',$companyId)->orderBy('id','DESC')->paginate(5);
            
           //$roles = Role::where('name', '!=','Super Admin');
           return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        }



        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role, User $user)
    {

         $role = $role;
         $permissions = $role->permissions;
         $permissions = Permission::get();


        $userInfo = Auth::user()->id;
        if($userInfo==5){

            $Company = Company::pluck('companyName','companyId');
            $permissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')
            ->get(['permissions.name AS permission_name','permissions.id AS permission_id', 'permissions.*']);
            
            return view('roles.create', compact('permissions','Company'));

        }

        else{
            
            $companyId = getusercompanyId();
            $Company = Company::where('companyId', $companyId)->pluck('companyName','companyId');
            $permissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')->where('roles.companyId', $companyId)
            ->get(['permissions.name AS permission_name','permissions.id AS permission_id', 'permissions.*']);
             return view('roles.create', compact('permissions','Company'));

        }
  
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userInfo = Auth::user()->id;

        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

    

        $name= $request->get('name');
        $companyId= $request->get('companyId');
        $contains= Str::contains( $name,'Super Admin');
        if($contains) {
            return redirect()->route('roles.index')
            ->with('error','Cannot create role with such name. Please choose any other name');
        }
        else{
           $role = Role::create(['name' => $request->get('name'),'createdBy'=>$userInfo,'companyId'=>$companyId],);
            $role->syncPermissions($request->get('permission'));
            return redirect()->route('roles.index')
                            ->with('success','Role created successfully');
        }
    
      
    }




    public function clonerole($id)
    {
      $userInfo = Auth::user()->id;
       $user = DB::table('roles')->where('id',$id)->first(); 

      if(empty($user)){
        return redirect()->route('roles.index')
        ->with('error','Role not found. Try again later');  
      }
      
      $userId=$user->id;
      $name=$user->name;
      $companyId=$user->companyId;
      
      
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 3; $i++) {
          $randomString .= $characters[random_int(0, $charactersLength - 1)];
      }
      
     $newname=$name.$randomString;
    
    
    $permisions = DB::table('role_has_permissions')->where('role_id',$id)->get();

     $contains= Str::contains($newname,'Super Admin');
        if($contains) {
            return redirect()->route('roles.index')
            ->with('error','Cannot create role with such name. Please choose any other name');
    }
    else{
    $role = Role::create(['name' => $newname,'createdBy'=>$userInfo,'companyId'=>$companyId],);
     
    $newroleId=$role->id;
     $count=count($permisions);

           if($count>0){
            foreach ($permisions as $permision) {
                $roleperm = new RolePermissions();
                $roleperm->permission_id= $permision->permission_id;
                $roleperm->role_id=$newroleId;
                $roleperm->save();


            }

            return redirect()->route('roles.index')
                            ->with('success','New Role Created Successfully');
        }
    
      
    }

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {

        // $userInfo = Auth::user()->id;
        // echo $user->getRoleNames();

        $role = $role;
        $rolePermissions = $role->permissions;
       return view('roles.show', compact('role', 'rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {   
        $userInfo = Auth::user()->id;
        if($userInfo==5){

           //$companyId = getusercompanyId();
            $role = $role;
            $rolePermissions = $role->permissions->pluck('name')->toArray();
            $permissions = Permission::get();

            return view('roles.edit', compact('role', 'rolePermissions', 'permissions'));

        }

        else{

            $companyId = getusercompanyId();
            $role = $role;
            $rolePermissions = $role->permissions->pluck('name')->toArray();
            //$permissions = Permission::get();
    
            $permissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')->where('roles.companyId', $companyId)
                ->get(['permissions.name AS permission_name','permissions.id AS permission_id', 'permissions.*']);
           return view('roles.edit', compact('role', 'rolePermissions', 'permissions'));

        }


        
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        
        $role->update($request->only('name'));
    
        $role->syncPermissions($request->get('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //$role->delete();

        return redirect()->route('roles.index')
        ->with('success','Role cannot be deleted ');
    }

}
