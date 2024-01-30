 <header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="{{ route('booking.dashboard') }}" class="logo d-flex align-items-center">
    <img src="assets/img/logo.png" alt="">
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
        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
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
    <a class="nav-link " href="{{ route('booking.dashboard') }}">
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
      <span>Companies</span>
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
    
    </ul>
  </li>

  @endif
 
 





  @if(auth()->user()->can('client.show') )
  
  <li class="nav-item">
    <a class="nav-link " href="{{ route('client.show') }}">
      <i class="bi bi-grid"></i>
      <span>All clients</span>
    </a>
  </li>


@endif




@if(auth()->user()->can('company.sendsms') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#messenger" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Messenger</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="messenger" class="nav-content collapse " data-bs-parent="#sidebar-nav">


    <li>
        <a href="{{ route('company.sendsms') }}">
          <i class="bi bi-circle"></i><span>Send Bulk sms</span>
        </a>
      </li>
      <li>
        <a href="{{ route('company.smsreport') }}">
          <i class="bi bi-circle"></i><span>Sms report</span>
        </a>
      </li>

    
    </ul>
  </li>

@endif




@if(auth()->user()->can('product.index') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#pos" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>POS</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="pos" class="nav-content collapse " data-bs-parent="#sidebar-nav">

    <li>
        <a href="{{ route('product.index') }}">
          <i class="bi bi-circle"></i><span>Products</span>
        </a>
      </li>
      <li>
        <a href="{{ route('productcategory.index') }}">
          <i class="bi bi-circle"></i><span>Category</span>
        </a>
      </li>

      <li>
        <a href="{{ route('pos.inventory') }}">
          <i class="bi bi-circle"></i><span>Inventory</span>
        </a>
      </li>


      <li>
        <a href="{{ route('pos.index') }}">
          <i class="bi bi-circle"></i><span>Pos</span>
        </a>
      </li>

      <li>
        <a href="{{ route('pos.alltransactions') }}">
          <i class="bi bi-circle"></i><span>Transactions</span>
        </a>
      </li>

      <a href="{{ route('pos.allsales') }}">
          <i class="bi bi-circle"></i><span>Sales report</span>
        </a>
      </li>

      

    
    </ul>
  </li>

@endif




@if(auth()->user()->can('company.sendsms') )
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#dept" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>HR</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="dept" class="nav-content collapse " data-bs-parent="#sidebar-nav">


    <li>
        <a href="{{ route('hr.alldepartments') }}">
          <i class="bi bi-circle"></i><span>Departments</span>
        </a>
      </li>
      <li>
        <a href="{{ route('hr.allJobs') }}">
          <i class="bi bi-circle"></i><span>Job Positions</span>
        </a>
      </li>


      <li>
        <a href="{{ route('hr.allSalary') }}">
          <i class="bi bi-circle"></i><span>All Salary</span>
        </a>
      </li>

      
    </ul>
  </li>

@endif
 

 

</ul>

</aside><!-- End Sidebar-->