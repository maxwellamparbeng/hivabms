 <!--
<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="{{ route('home.index') }}" class="nav-link px-2 text-white">Home</a></li>
        @auth
          @role('Admin')
          <li><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">Users</a></li>
          <li><a href="{{ route('roles.index') }}" class="nav-link px-2 text-white">Roles</a></li>
          @endrole
          <li><a href="{{ route('roles.index') }}" class="nav-link px-2 text-white">Posts</a></li>
        @endauth
      </ul>

      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
      </form>

      @auth
        {{auth()->user()->name}}&nbsp;
        <div class="text-end">
          <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
        </div>
      @endguest
    </div>
  </div>
</header>


 ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="{{ route('home.index') }}" class="logo d-flex align-items-center">
    <img src="/assets/img/hiva-bms.png" alt="">
    <span class="d-none d-lg-block">HBMS</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
  </form>
</div><!-- End Search Bar -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->

    <!-- End Notification Nav -->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-chat-left-text"></i>
        <span class="badge bg-success badge-number">0</span>
      </a><!-- End Messages Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
        <li class="dropdown-header">
          
          <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2"></span></a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

      

      </ul><!-- End Messages Dropdown Items -->

    </li><!-- End Messages Nav -->

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="/assets/img/profile-img.png" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2">
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6>@auth
        {{auth()->user()->name}}&nbsp; @endauth</span></h6>
         
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="{{ route('users.show',auth()->user()->id) }}">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="{{ route('users.edit',auth()->user()->id) }}">
            <i class="bi bi-gear"></i>
            <span>Account Settings</span>
          </a>
        </li>
        
        
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="{{route('logout.perform') }}">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">


@if(auth()->user()->can('home.index') )

  <li class="nav-item">
    <a class="nav-link " href="{{ route('home.index') }}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->
  @endif
  


    
   
   
    @if(auth()->user()->can('home.index') )
  
    <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#perm-navs" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Configurations</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="perm-navs" class="nav-content collapse " data-bs-parent="#sidebar-nav">

    @if(auth()->user()->can('users.index') )
       <li>
        <a href="{{ route('users.index') }}">
          <i class="bi bi-circle"></i><span>Users</span>
        </a>
      </li>
      @endif


      @if(auth()->user()->can('roles.index') )
      <li>
        <a href="{{ route('roles.index') }}">
          <i class="bi bi-circle"></i><span>Roles</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('company.index') )
      <li class="">
    <a  href="{{ route('company.index') }}">
      <i class="bi bi-grid"></i>
      

<?php
$userType=getusertypeInfo();

if($userType=="Super Admin"){
  echo'<span>Companies</span>';
}
else{

  echo'<span>Company Info</span>';
}

?>
      


    </a>
  </li>
    @endif


    @if(auth()->user()->can('roles.index') )
      <li>
        <a href="{{ route('branch.index') }}">
          <i class="bi bi-circle"></i><span>Branches</span>
        </a>
      </li>
      @endif



      @if(auth()->user()->can('companysubscriptions.index') )
      <li>
        <a href="{{ route('companysubscriptions.index') }}">
          <i class="bi bi-circle"></i><span>Subscriptions</span>
        </a>
      </li>
      @endif



    
    
    </ul>
  </li>

  @endif
 
 





  @if(auth()->user()->can('client.show') )
  
  <li class="nav-item">
    <a class="nav-link " href="{{ route('client.show') }}">
      <i class="bi bi-grid"></i>
      <span>Customers</span>
    </a>
  </li>


@endif




@if(auth()->user()->can('company.sendsms') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#messenger" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Messenger</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="messenger" class="nav-content collapse " data-bs-parent="#sidebar-nav">


    @if(auth()->user()->can('company.sendsms') )
    <li>
        <a href="{{ route('company.sendsms') }}">
          <i class="bi bi-circle"></i><span>Send Bulk sms</span>
        </a>
      </li>

      @endif

      @if(auth()->user()->can('company.smsreport') )
      <li>
        <a href="{{ route('company.smsreport') }}">
          <i class="bi bi-circle"></i><span>Sms report</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('company.buysmsbundle') )
      <li>
        <a href="{{ route('company.buysmsbundle') }}">
          <i class="bi bi-circle"></i><span>Buy Sms Bundle</span>
        </a>
      </li>
      @endif
      
    
    </ul>
  </li>

@endif




@if(auth()->user()->can('pos.index') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#pos" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>POS</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="pos" class="nav-content collapse " data-bs-parent="#sidebar-nav">

    @if(auth()->user()->can('pos.index') )
    <li>
        <a href="{{ route('pos.index') }}">
          <i class="bi bi-circle"></i><span>Pos</span>
        </a>
      </li>

      @endif

      @if(auth()->user()->can('product.index') )
    <li>
        <a href="{{ route('product.index') }}">
          <i class="bi bi-circle"></i><span>Products</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('productcategory.index') )
      <li>
        <a href="{{ route('productcategory.index') }}">
          <i class="bi bi-circle"></i><span>Category</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('pos.inventory') )
      <li>
        <a href="{{ route('pos.inventory') }}">
          <i class="bi bi-circle"></i><span>Inventory</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('receipt.managereceiptnote') )
      <li>
        <a href="{{ route('receipt.managereceiptnote') }}">
          <i class="bi bi-circle"></i><span>Receipt note setup</span>
        </a>
      </li>

      @endif

      @if(auth()->user()->can('pos.managevatsetup') )
      <li>
        <a href="{{ route('pos.managevatsetup') }}">
          <i class="bi bi-circle"></i><span>Vat Setup</span>
        </a>
      </li>
      @endif
      
      @if(auth()->user()->can('pos.allsales') )
       <li>
    
      <a href="{{ route('pos.allsales') }}">
          <i class="bi bi-circle"></i><span>Sales report</span>
        </a>
      </li>
      @endif


      @if(auth()->user()->can('pos.transferstocklog') )

      <li>
        <a href="{{ route('pos.transferstocklog') }}">
          <i class="bi bi-circle"></i><span>Stock Transfer report</span>
        </a>
      </li>
      @endif
      

    
    </ul>
  </li>

@endif




@if(auth()->user()->can('hr.allEmployees') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#dept" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>HR</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="dept" class="nav-content collapse " data-bs-parent="#sidebar-nav">


    @if(auth()->user()->can('hr.alldepartments') )
    <li>
        <a href="{{ route('hr.alldepartments') }}">
          <i class="bi bi-circle"></i><span>Departments</span>
        </a>
      </li>

      @endif

      @if(auth()->user()->can('hr.allJobs') )
      <li>
        <a href="{{ route('hr.allJobs') }}">
          <i class="bi bi-circle"></i><span>Job Positions</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('hr.allSalary') )

      <li>
        <a href="{{ route('hr.allSalary') }}">
          <i class="bi bi-circle"></i><span>Salary</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('hr.allEmployees') )
      <li>
        <a href="{{ route('hr.allEmployees') }}">
          <i class="bi bi-circle"></i><span>Employees</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('payroll.allAllowance') )
      <li>
        <a href="{{ route('payroll.allAllowance') }}">
          <i class="bi bi-circle"></i><span>Allowance</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('payroll.allDeduction') )
      <li>
        <a href="{{ route('payroll.allDeduction') }}">
          <i class="bi bi-circle"></i><span>Deductions</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('payroll.allpayroll') )
      <li>
        <a href="{{ route('payroll.allpayroll') }}">
          <i class="bi bi-circle"></i><span>Payroll</span>
        </a>
      </li>
      @endif

      

      
    </ul>
  </li>

@endif






@if(auth()->user()->can('expense.index') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#finance" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Finance</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="finance" class="nav-content collapse " data-bs-parent="#sidebar-nav">


    @if(auth()->user()->can('expense.category.index') )
    <li>
        <a href="{{ route('expense.category.index') }}">
          <i class="bi bi-circle"></i><span>Expense Category</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('expense.index') )

      <li>
        <a href="{{ route('expense.index') }}">
          <i class="bi bi-circle"></i><span>Expense</span>
        </a>
      </li>

      @endif

      @if(auth()->user()->can('account.index') )
      <li>
        <a href="{{ route('account.index') }}">
          <i class="bi bi-circle"></i><span>Accounts</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('account.transactions') )
      <li>
        <a href="{{ route('account.transactions') }}">
          <i class="bi bi-circle"></i><span>Acc Transactions</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('debt.index') )
      <li>
        <a href="{{ route('debt.index') }}">
          <i class="bi bi-circle"></i><span>Debt</span>
        </a>
      </li>
      @endif 

      
    </ul>
  </li>

@endif








@if(auth()->user()->can('invoice.index') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#invoice" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Invoice</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="invoice" class="nav-content collapse " data-bs-parent="#sidebar-nav">

    @if(auth()->user()->can('invoice.manageinvoicenote') )

    <li>
        <a href="{{ route('invoice.index') }}">
          <i class="bi bi-circle"></i><span>Create Invoice</span>
        </a>
      </li>

      @endif
      
      @if(auth()->user()->can('invoice.manageinvoicenote') )
    <li>
        <a href="{{ route('invoice.manageinvoicenote') }}">
          <i class="bi bi-circle"></i><span>Invoice Note</span>
        </a>
      </li>
      @endif
      
      @if(auth()->user()->can('invoice.allinvoice') )

      <li>
        <a href="{{ route('invoice.allinvoice') }}">
          <i class="bi bi-circle"></i><span>Invoices</span>
        </a>
      </li>
      @endif
      
    </ul>
  </li>

@endif






@if(auth()->user()->can('warehouse.index') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#warehouse" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Warehouses</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="warehouse" class="nav-content collapse " data-bs-parent="#sidebar-nav">


    @if(auth()->user()->can('warehouse.index') )


   
    <li>
        <a href="{{ route('warehouse.index') }}">
          <i class="bi bi-circle"></i><span>Warehouses</span>
        </a>
      </li>

      @endif


      @if(auth()->user()->can('warehouse.transferstocklog') )
      <li>
        <a href="{{ route('warehouse.transferstocklog') }}">
          <i class="bi bi-circle"></i><span>Transfer Report</span>
        </a>
      </li>
      @endif
      
      
    </ul>
  </li>

@endif
 


@if(auth()->user()->can('hivapay.menu') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#pay" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Hiva pay</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    
    <?php
    if(session('merchantId')!==null && session('tk') !==null  ){

echo '<ul id="pay" class="nav-content collapse " data-bs-parent="#sidebar-nav">';
    }

    else{
      echo '<ul id="pay" class="nav-content collapse " data-bs-parent="#sidebar-nav">';
}
 ?>


@if(auth()->user()->can('hivapay.menu') )

@if(session()->has('merchantId') && session()->has('tk') )
  


@if(auth()->user()->can('hivapay.dashboard') )
  
  <li class="nav-item">
    <a class="nav-link " href="{{ route('hivapay.dashboard') }}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>


    @endif



    @if(auth()->user()->can('hivapay.alltransactions') )
  
  <li class="nav-item">
    <a class="nav-link " href="{{ route('hivapay.alltransactions') }}">
      <i class="bi bi-grid"></i>
      <span>Transactions</span>
    </a>
  </li>


    @endif


    @if(auth()->user()->can('hivapay.paymentlinks') )
  
  <li class="nav-item">
    <a class="nav-link " href="{{ route('hivapay.paymentlinks') }}">
      <i class="bi bi-grid"></i>
      <span>Payment Links</span>
    </a>
  </li>


    @endif



    @if(auth()->user()->can('hivapay.transferandacceptfunds') )
  
  <li class="nav-item">
    <a class="nav-link " href="{{ route('hivapay.transferandacceptfunds') }}">
      <i class="bi bi-grid"></i>
      <span>Transfer / Receive funds</span>
    </a>
  </li>


  <li class="nav-item">
  <a class="nav-link " href="{{ route('hivapay.menu') }}">
    <i class="bi bi-grid"></i>
    <span>Logout</span>
  </a>
</li>


    @endif



@else
<li class="nav-item">
  <a class="nav-link " href="{{ route('hivapay.menu') }}">
    <i class="bi bi-grid"></i>
    <span>Branches</span>
  </a>
</li>


@endif
@endif
    
   


    
    
      
    </ul>
  </li>

@endif

 

</ul>

</aside><!-- End Sidebar-->