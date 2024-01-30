<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
   
   
    

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
        
        Route::get('/showbooking', 'BookingController@showbooking')->name('booking.index');
        Route::post('/store', 'BookingController@store')->name('booking.store');
        Route::get('/bookingpay', 'BookingController@showpaymentpage')->name('booking.pay');
        Route::post('/processPayament','BookingController@processPayament')->name('booking.process');
        Route::get('/testing','BookingController@testing')->name('booking.testing');
   
    });
    
             //start

             Route::get('/{bookingId}/edit','AdminController@edit')->name('booking.edit');
             Route::post('/{bookingId}/update','AdminController@update')->name('booking.update');
             Route::post('/storecompanyinfo','CompanyController@companystore')->name('company.store');
             Route::get('/allcompanies','CompanyController@allcompanies')->name('company.index');
             Route::get('/addnewcompany','CompanyController@addnewcompany')->name('company.addnewcompany');
             Route::get('/{companyId}/editcompany','CompanyController@editcompany')->name('company.editcompany');
             Route::post('/{companyId}/updatecompany','CompanyController@updatecompany')->name('company.updatecompany');
             
             Route::post('/storeclientinfo','ClientController@store')->name('client.store');
             Route::get('/allclients','ClientController@allclients')->name('client.show');
             Route::get('/addnewclient','ClientController@addnewclient')->name('client.index');
             Route::get('/{clientId}/editclient','ClientController@editclient')->name('client.editclient');
             Route::post('/{clientId}/updateclient','ClientController@updateclient')->name('client.updateclient');

             Route::post('/storeproduct','ProductController@productstore')->name('products.store');
             Route::get('/allproducts','ProductController@allproducts')->name('product.index');
             Route::get('/addproduct','ProductController@addproduct')->name('product.add');
             Route::get('/{productId}/editproduct','ProductController@editproduct')->name('product.edit');
             Route::post('/{productId}/updateproduct','ProductController@updateproduct')->name('product.updateproduct');
         
             Route::post('/storeproductcategory','ProductCategoryController@productcategorystore')->name('productcategory.store');
             Route::get('/allcategory','ProductCategoryController@allcategory')->name('productcategory.index');
             Route::get('/addproductcategory','ProductCategoryController@addproductcategory')->name('productcategory.add');
             Route::get('/{categoryId}/editproductcategory','ProductCategoryController@editproductcategory')->name('productcategory.edit');
             Route::post('/{categoryId}/updateproductcategory','ProductCategoryController@updateproductcategory')->name('productcategory.updateproductcategory');
         
             Route::get('image/{filename}', 'AdminController@displayImage')->name('image.displayImage');
             Route::get('/test','AdminController@test')->name('admin.test');
             Route::get('/sendsms','MessengerController@sendsms')->name('company.sendsms');
             Route::get('/smsreport','MessengerController@smsreport')->name('company.smsreport');
             Route::post('/executesms','MessengerController@executesms')->name('company.executesms');
             Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
             
             Route::get('/pos','PosController@pos')->name('pos.index');
             Route::post('/pos','PosController@updatequantity')->name('pos.updatequantity');
             Route::get('deleteitem/{id}/','PosController@deleteitem')->name('pos.deletecart');
             Route::post('/pos','PosController@creatorder')->name('pos.createorder');
             Route::get('/alltransactions','PosController@alltransactions')->name('pos.alltransactions');
             Route::get('/transactiondetails/{id}/','PosController@transactiondetails')->name('pos.viewtransactiondetails');
             Route::get('/deletetransactionitem/{id}/','PosController@deletetransactionitem')->name('pos.deletetransactionitem');
             Route::post('/updateproductdetailsquantity','PosController@updateproductdetailsquantity')->name('pos.updateproductdetailsquantity');
             Route::get('/allsales','PosController@allsales')->name('pos.allsales');
             Route::post('/add','PosController@add')->name('pos.add');
             Route::get('/product-search','PosController@searchproduct')->name('pos.productsearch');
             Route::get('/inventory','PosController@inventory')->name('pos.inventory');
             
             Route::get('/viewreceipt/{id}/','PosController@viewreceipt')->name('pos.viewreceipt');
             
         
             Route::post('/storebranch','BranchController@branchstore')->name('branch.store');
             Route::get('/allbranches','BranchController@allbranches')->name('branch.index');
             Route::get('/addbranch','BranchController@addbranch')->name('branch.add');
             Route::get('/{branchId}/editbranch','BranchController@editbranch')->name('branch.edit');
             Route::post('/{branchId}/updatebranch','BranchController@updatebranch')->name('branch.updatebranch');
             

             Route::post('/storedepartment','HrController@storeDepartment')->name('hr.storeDepartment');
             Route::get('/alldepartments','HrController@alldepartments')->name('hr.alldepartments');
             Route::get('/addDepartment','HrController@addDepartment')->name('hr.addDepartment');
             Route::get('/{deptId}/editDepartment','HrController@editDepartment')->name('hr.editDepartment');
             Route::post('/{deptId}/updateDepartment','HrController@updateDepartment')->name('hr.updateDepartment');
           

             Route::post('/storeJob','HrController@storeJob')->name('hr.storeJob');
             Route::get('/allJobs','HrController@allJobs')->name('hr.allJobs');
             Route::get('/addJob','HrController@addJob')->name('hr.addJob');
             Route::get('/{jobId}/editJob','HrController@editJob')->name('hr.editJob');
             Route::post('/{jobId}/updateJob','HrController@updateJob')->name('hr.updateJob');

         //end
           



    Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        //Route::get('/', 'HomeController@index')->name('home.index');
        Route::get('/', 'AdminController@dashboard')->name('booking.dashboard');
        Route::get('/dashboard','AdminController@dashboard')->name('dashboard.dashboard');
        //Route::get('/allbookings','AdminController@allbookings')->name('bookings.show');
       
        
        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });

        /**
         * User Routes
         * 
         * 
         * 
         */



        Route::group(['prefix' => 'posts'], function() {
            Route::get('/', 'PostsController@index')->name('posts.index');
            Route::get('/create', 'PostsController@create')->name('posts.create');
            Route::post('/create', 'PostsController@store')->name('posts.store');
            Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
            Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
            Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
            Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
        });

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
});
