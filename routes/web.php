<?php

use Illuminate\Support\Facades\Route;
Route::group(['namespace' => 'App\Http\Controllers'], function()
{ 
    
    Route::group(['middleware' => ['guest']], function() {
    
        //Route::get('/register', 'RegisterController@show')->name('register.show');
        //Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
        Route::get('/clientinfo','PosController@clientinfo')->name('pos.clientinfo');
        
        // Route::get('/showbooking', 'BookingController@showbooking')->name('booking.index');
        // Route::post('/store', 'BookingController@store')->name('booking.store');
        // Route::get('/bookingpay', 'BookingController@showpaymentpage')->name('booking.pay');
        // Route::post('/processPayament','BookingController@processPayament')->name('booking.process');
        // Route::get('/testing','BookingController@testing')->name('booking.testing');
        
        
        Route::post('/storeExternalClient','ClientController@storeExternalClient')->name('client.storeExternalClient');
        Route::get('/addClientExternal/{id}','ClientController@addClientExternal')->name('client.addClientExternal');

   
        Route::get('/index','EmailController@index')->name('email.index');
    });
    
    
    Route::get('/receivePayment/{id}','PaymentController@receivePayment')->name('pay.invoice'); 
    Route::get('/finalizePayment','PaymentController@finalizePayment')->name('pay.finalize');
    Route::get('/incometax','PayrollController@incometax')->name('payroll.incometax');
    
    
    Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        //Route::get('/', 'HomeController@index')->name('home.index');
         Route::get('/', 'AdminController@dashboard')->name('home.index');
        Route::get('/dashboard','AdminController@dashboard')->name('home.index');
        
       
        
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
            Route::post('/updatepassword', 'UsersController@updatepassword')->name('users.changepassword');
            Route::get('/resetpassword/{id}/', 'UsersController@resetpassword')->name('users.resetpassword');
            
        });

        /**
         * User Routes
         * 
         * 
         * 
         */



        // Route::group(['prefix' => 'posts'], function() {
        //     Route::get('/', 'PostsController@index')->name('posts.index');
        //     Route::get('/create', 'PostsController@create')->name('posts.create');
        //     Route::post('/create', 'PostsController@store')->name('posts.store');
        //     Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
        //     Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
        //     Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
        //     Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
        // });

        //clonerole($id)

        Route::get('/clonerole/{id}/', 'RolesController@clonerole')->name('role.clone');
        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);


         //start
         Route::post('/addSingleDeduction','PayrollController@addSingleDeduction')->name('payroll.addSingleDeduction');
         Route::post('/addSingleAllowance','PayrollController@addSingleAllowance')->name('payroll.addSingleAllowance');
         Route::post('/addMassDeduction','PayrollController@addMassDeduction')->name('payroll.addMassDeduction');
         Route::post('/addMassAllowance','PayrollController@addMassAllowance')->name('payroll.addMassAllowance');
         Route::post('/reset','PayrollController@reset')->name('payroll.reset');
         
         Route::post('/expensecategorystore','ExpenseController@expenseCategoryStore')->name('expense.category.store');
         Route::get('/allexpensecategory','ExpenseController@allExpenseCategory')->name('expense.category.index');
         Route::get('/addexpensecategory','ExpenseController@addExpenseCategory')->name('expense.category.add');
         Route::get('/{expensecategoryId}/editexpensecategory','ExpenseController@editExpenseCategory')->name('expense.category.edit');
         Route::post('/{expensecategoryId}/updateExpensecategory','ExpenseController@updateExpenseCategory')->name('expense.category.updateExpensecategory');
     
         Route::post('/expensestore','ExpenseController@expenseStore')->name('expense.store');
         Route::get('/allexpense','ExpenseController@allExpense')->name('expense.index');
         Route::get('/addexpense','ExpenseController@addExpense')->name('expense.add');
         Route::get('/{expenseId}/editexpense','ExpenseController@editExpense')->name('expense.edit');
         Route::post('/{expenseId}/updateExpensecategory','ExpenseController@updateExpense')->name('expense.updateExpense');
     

         Route::get('/allAccounts','AccountController@allAccounts')->name('account.index');
         Route::get('/addAccount','AccountController@addAccount')->name('account.add');
         Route::post('/AccountsStore','AccountController@AccountsStore')->name('account.store');
         Route::get('/{accountId}/editAccount','AccountController@editAccount')->name('account.edit');
         Route::post('/{accountId}/updateAccount','AccountController@updateAccount')->name('account.update');


         Route::get('/allAccountTransactions','AccountController@allAccountTransactions')->name('account.transactions');
         Route::post('/AccountsTransactionStore','AccountController@AccountsTransactionStore')->name('account.addtransaction');
         Route::get('/{transactionId}/editAccountTransaction','AccountController@editAccountTransaction')->name('account.editTransaction');
         Route::get('/{transactionId}/TransactionsByAccount','AccountController@TransactionsByAccount')->name('account.TransactionsByAccount');
         Route::post('/{transactionId}/updateAccountTransaction','AccountController@updateAccountTransaction')->name('account.updatetransaction');
         Route::post('/accountTransactionReport','AccountController@accountTransactionReport')->name('account.transactionreport');
         
         Route::get('/allDebt','AccountController@allDebt')->name('debt.index');
         Route::get('/addDebt','AccountController@addDebt')->name('debt.add');
         Route::post('/DebtStore','AccountController@DebtStore')->name('debt.store');
         Route::get('/{debtId}/editDebt','AccountController@editDebt')->name('debt.edit');
         Route::post('/{debtId}/updateDebt','AccountController@updateDebt')->name('debt.update');
         Route::post('/debtReport','AccountController@debtReport')->name('debt.report');
        
         Route::get('/addpayroll','PayrollController@addpayroll')->name('payroll.addpayroll');
         Route::get('/allpayroll','PayrollController@allpayroll')->name('payroll.allpayroll');
         Route::get('/deleteDeduction/{id}','PayrollController@deleteDeduction')->name('payroll.deleteDeduction');
         Route::get('/deleteAllowance/{id}','PayrollController@deleteAllowance')->name('payroll.deleteAllowance');
         Route::get('/attendance/{id}','PayrollController@attendance')->name('payroll.attendance');
         Route::get('/attendancePdf/{id}','PayrollController@attendancePdf')->name('payroll.attendancepdf');
         Route::get('/payrollpdf/{id}','PayrollController@payrollpdf')->name('payroll.payrollpdf');
         
         
        
         Route::post('/updateAttendance','PayrollController@updateAttendance')->name('payroll.updateAttendance');
         Route::get('/payroll/{id}','PayrollController@payroll')->name('payroll.payroll');
         Route::get('/payslip/{id}','PayrollController@payslip')->name('payroll.payslip');
         Route::post('/createPayroll','PayrollController@createPayroll')->name('payroll.createPayroll');
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
         Route::get('/exportclients','ClientController@exportclients')->name('export.clients');
    
         Route::post('/contactGroupStore','ClientController@contactGroupStore')->name('contactgroup.store');
         Route::post('updateContactGroup','ClientController@updateContactGroup')->name('contactgroup.update');
         Route::get('/{contactgroupId}/viewbycontactgroupId','ClientController@viewbycontactgroupId')->name('contactgroup.view');
         

         Route::post('/storeproduct','ProductController@productstore')->name('products.store');
         Route::get('/allproducts','ProductController@allproducts')->name('product.index');
         Route::get('/addproduct','ProductController@addproduct')->name('product.add');
         Route::get('/{productId}/editproduct','ProductController@editproduct')->name('product.edit');
         Route::post('/{productId}/updateproduct','ProductController@updateproduct')->name('product.updateproduct');
         Route::get('/exportProduct','ProductController@exportProduct')->name('export.Product');
         Route::get('/{productId}/deleteProduct','ProductController@deleteProduct')->name('product.delete');

         
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
         Route::get('/buysmsbundle','MessengerController@buysmsbundle')->name('company.buysmsbundle');
          
         
         Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
         
         Route::get('/pos','PosController@pos')->name('pos.index');
         Route::post('/updatequantity','PosController@updatequantity')->name('pos.updatequantity');
         Route::get('deleteitem/{id}/','PosController@deleteitem')->name('pos.deletecart');
         Route::post('/pos','PosController@creatorder')->name('pos.createorder');
         Route::get('/alltransactions','PosController@alltransactions')->name('pos.alltransactions');
         Route::get('/transactiondetails/{id}/','PosController@transactiondetails')->name('pos.viewtransactiondetails');
         Route::get('/deletetransactionitem/{id}/','PosController@deletetransactionitem')->name('pos.deletetransactionitem');
         Route::post('/updateproductdetailsquantity','PosController@updateproductdetailsquantity')->name('pos.updateproductdetailsquantity');
         Route::get('/allsales','PosController@allsales')->name('pos.allsales');
         Route::post('/salesreport','PosController@salesdaterange')->name('pos.salesdaterange');
         Route::post('/exportInventoryLog','PosController@exportInventoryLog')->name('pos.exportInventoryLog');
         
         Route::get('/cancelreceipt/{id}/','PosController@cancelreceipt')->name('pos.cancelreceipt');
         Route::get('/cancelinvoice/{id}/','InvoiceController@cancelinvoice')->name('invoice.cancel');
         Route::get('/viewTransactionLog/{id}/','PosController@viewTransactionLog')->name('pos.viewTransactionLog');

         Route::post('/add','PosController@add')->name('pos.add');
         Route::get('/product-search','PosController@searchproduct')->name('pos.productsearch');
         Route::get('/inventory','PosController@inventory')->name('pos.inventory');
         Route::get('/branchinventory/{id}/','PosController@branchinventory')->name('pos.branchinventory');
         
         Route::post('/updateinventory','PosController@updateinventory')->name('pos.updateinventory');
         Route::get('/viewreceipt/{id}/','PosController@viewreceipt')->name('pos.viewreceipt');
         Route::get('/viewminireceipt/{id}/','PosController@viewminireceipt')->name('pos.viewminireceipt');
         
     
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


         Route::post('/storeSalary','HrController@storeSalary')->name('hr.storeSalary');
         Route::get('/allSalary','HrController@allSalary')->name('hr.allSalary');
         Route::get('/addSalary','HrController@addSalary')->name('hr.addSalary');
         Route::get('/{salaryId}/editSalary','HrController@editSalary')->name('hr.editSalary');
         Route::post('/{salaryId}/updateSalary','HrController@updateSalary')->name('hr.updateSalary');


         Route::post('/storeEmployee','HrController@storeEmployee')->name('hr.storeEmployee');
         Route::get('/allEmployees','HrController@allEmployees')->name('hr.allEmployees');
         Route::get('/addEmployee','HrController@addEmployee')->name('hr.addEmployee');
         Route::get('/{employeeId}/editEmployee','HrController@editEmployee')->name('hr.editEmployee');
         Route::post('/{employeeId}/updateEmployee','HrController@updateEmployee')->name('hr.updateEmployee');

         

         Route::post('/storeDeduction','PayrollController@storeDeduction')->name('payroll.storeDeduction');
         Route::get('/allDeduction','PayrollController@allDeduction')->name('payroll.allDeduction');
         Route::get('/addDeduction','PayrollController@addDeduction')->name('payroll.addDeduction');
         Route::get('/{deductionId}/editDeduction','PayrollController@editDeduction')->name('payroll.editDeduction');
         Route::post('/{deductionId}/updateDeduction','PayrollController@updateDeduction')->name('payroll.updateDeduction');


         Route::post('/storeAllowance','PayrollController@storeAllowance')->name('payroll.storeAllowance');
         Route::get('/allAllowance','PayrollController@allAllowance')->name('payroll.allAllowance');
         Route::get('/addAllowance','PayrollController@addAllowance')->name('payroll.addAllowance');
         Route::get('/{allowanceId}/editAllowance','PayrollController@editAllowance')->name('payroll.editAllowance');
         Route::post('/{allowanceId}/updateAllowance','PayrollController@updateAllowance')->name('payroll.updateAllowance');


         Route::get('/invoice','InvoiceController@invoice')->name('invoice.index');
         Route::post('/updateinvoicequantity','InvoiceController@updateinvoicequantity')->name('invoice.updateinvoicequantity');
         Route::get('deleteinvoiceitem/{id}/','InvoiceController@deleteinvoiceitem')->name('invoice.deleteinvoiceitem');
         Route::post('/createinvoice','InvoiceController@createinvoice')->name('invoice.createinvoice');
         Route::post('/addinvoice','InvoiceController@addinvoice')->name('invoice.addinvoice');
         
         Route::get('/allinvoice','InvoiceController@allinvoice')->name('invoice.allinvoice');
         Route::post('/invoicereport','InvoiceController@salesdaterange')->name('invoice.salesdaterange');
         Route::get('/alltransactions','InvoiceController@alltransactions')->name('invoice.alltransactions');
         Route::get('/invoicetransactiondetails/{id}/','InvoiceController@transactiondetails')->name('invoice.viewtransactiondetails');
         
         Route::get('/viewinvoice/{id}/','InvoiceController@viewinvoice')->name('invoice.viewinvoice');
         Route::post('/editinvoice','InvoiceController@editinvoice')->name('invoice.editinvoice');
         
         Route::post('/invoicesalesdaterange','InvoiceController@invoicesalesdaterange')->name('invoice.invoicesalesdaterange');

         Route::get('/manageinvoicenote','InvoiceController@manageinvoicenote')->name('invoice.manageinvoicenote');
         Route::get('/addinvoicenote','InvoiceController@addinvoicenote')->name('invoice.addnote');
         Route::post('/updateinvoicenote','InvoiceController@updateinvoicenote')->name('invoice.updatenote');
         Route::post('storenote','InvoiceController@storenote')->name('invoice.storeNote');
         Route::get('/{noteId}/editinvoicenote','InvoiceController@editinvoicenote')->name('invoicenote.edit');
         
         Route::get('/managereceiptnote','PosController@managereceiptnote')->name('receipt.managereceiptnote');
         Route::get('/addreceiptnote','PosController@addreceiptnote')->name('receipt.addnote');
         Route::post('/updatereceiptnote','PosController@updatereceiptnote')->name('receipt.updatenote');
         Route::post('storenote','PosController@storenote')->name('receipt.storeNote');
         Route::get('/{noteId}/editreceiptnote','PosController@editreceiptnote')->name('receiptnote.edit');
         Route::post('/editreceipt','PosController@editreceipt')->name('pos.editreceipt');
        
         
         Route::get('/managevatsetup','PosController@managevatsetup')->name('pos.managevatsetup');
         Route::get('/addvat','PosController@addvat')->name('pos.addvat');
         Route::post('/updatevat','PosController@updatevat')->name('pos.updatevat');
         Route::post('storevat','PosController@storevat')->name('pos.storevat');
         Route::get('/{vatId}/editvat','PosController@editvat')->name('pos.editvat');
         

         Route::get('/export','PosController@export')->name('export.sales');
         Route::post('/searchtransaction','PosController@searchtransaction')->name('pos.searchtransaction');
         Route::get('/exportInventory/{id}/','PosController@exportInventory')->name('pos.exportInventory');
         Route::post('/searchinvoice','InvoiceController@searchinvoice')->name('invoice.searchinvoice');
         
         
         Route::post('reducestock','PosController@reducestock')->name('pos.reducestock');
         Route::post('transferstock','PosController@transferstock')->name('pos.transferstock');
         Route::get('transferstocklog','PosController@transferstocklog')->name('pos.transferstocklog');
        
        
        
         Route::post('/storewarehouse','WarehouseController@storewarehouse')->name('warehouse.store');
         Route::get('/allwarehouses','WarehouseController@allwarehouses')->name('warehouse.index');
         Route::get('/addwarehouse','WarehouseController@addwarehouse')->name('warehouse.add');
         Route::get('/{warehouseId}/editwarehouse','WarehouseController@editwarehouse')->name('warehouse.edit');
         Route::post('/{warehouseId}/updatewarehouse','WarehouseController@updatewarehouse')->name('warehouse.updatewarehouse');
         

         Route::get('/{warehouseId}/warehouseinventory','WarehouseController@warehouseinventory')->name('warehouse.inventory');
         Route::get('/{warehouseId}/exportwarehouseinventory/','WarehouseController@exportwarehouseinventory')->name('warehouse.exportInventory');
         Route::post('/exportwarehouseinventorylog','WarehouseController@exportwarehouseinventorylog')->name('warehouse.exportInventoryLog');


         Route::post('/reducewarehousestock','WarehouseController@reducewarehousestock')->name('warehouse.reducestock');
         Route::post('/transferwarehousestock','WarehouseController@transferwarehousestock')->name('warehouse.transferstock');
         Route::get('/warehousetransferstocklog','WarehouseController@warehousetransferstocklog')->name('warehouse.transferstocklog');
         Route::post('updatewarehouseinventory','WarehouseController@updatewarehouseinventory')->name('warehouse.updatewarehouseinventory');
         

         Route::get('/branches','PaymentController@branches')->name('hivapay.menu');
         Route::get('/{id}/Loginintohivapay/','PaymentController@Loginintohivapay')->name('hivapay.login');
         Route::get('hpdashboard','PaymentController@hpdashboard')->name('hivapay.dashboard');
         Route::get('allhptransactions','PaymentController@allhptransactions')->name('hivapay.alltransactions');
         Route::get('hplogout','PaymentController@hplogout')->name('hivapay.logout');
         Route::get('allhppendingtransactions','PaymentController@allhppendingtransactions')->name('hivapay.pendingtransactions');
         Route::get('/{id}/resolvehppayment/','PaymentController@resolvehppayment')->name('hivapay.resolvepayment');
         Route::post('searchhptransactions','PaymentController@searchhptransactions')->name('hivapay.searchhptransactions');
         Route::get('paymentlinks','PaymentController@paymentlinks')->name('hivapay.paymentlinks');
         Route::get('/{id}/paymentsbylink/','PaymentController@paymentsbylink')->name('hivapay.paymentsbylink');
         Route::post('createpaylink','PaymentController@createpaylink')->name('hivapay.createpaymentlink');
         Route::get('transferandacceptfunds','PaymentController@transferandacceptfunds')->name('hivapay.transferandacceptfunds');
         Route::post('initiatefundtransfer','PaymentController@initiatefundtransfer')->name('hivapay.initiatefundtransfer');
         Route::get('verifyfundtransferdetails','PaymentController@verifyfundtransferdetails')->name('hivapay.verifyfundtransferdetails');
         Route::post('finalizefundtransfer','PaymentController@finalizefundtransfer')->name('hivapay.finalizefundtransfer');
         
         Route::get('hpinitiatereceivefunds','PaymentController@hpinitiatereceivefunds')->name('hivapay.hpinitiatereceivefunds');
         Route::post('hpfinalizereceivefunds','PaymentController@hpfinalizereceivefunds')->name('hivapay.hpfinalizereceivefunds');
         Route::get('/allsubscriptions','SubscriptionController@allsubscriptions')->name('companysubscriptions.index');
         Route::get('/initiatesubscriptionpayment/{id}','PaymentController@initiatesubscriptionpayment')->name('subscription.pay'); 
        

         
        
         
        
        
         //  Route::get('/deletetransactionitem/{id}/','PosController@deletetransactionitem')->name('pos.deletetransactionitem');
        //  Route::post('/updateproductdetailsquantity','PosController@updateproductdetailsquantity')->name('pos.updateproductdetailsquantity');
        
         
      
        //  Route::get('/product-search','PosController@searchproduct')->name('pos.productsearch');
        //  Route::get('/inventory','PosController@inventory')->name('pos.inventory');



         
     //end







    });
});
