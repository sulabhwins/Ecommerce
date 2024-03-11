  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('admin/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">E Com</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Auth::guard('admin')->user()->image ? asset(Auth::guard('admin')->user()->image) : asset('admin/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><strong>{{ Auth::guard('admin')->user()->name }} ({{ Auth::guard('admin')->user()->type }})</strong></a>
        </div>
      </div>
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('admin/update-password')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin Password </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/update-admin-details')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin Details</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/cms-pages')}}" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Cms Pages
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/subadmins')}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Subadmins
              </p>
            </a>
          <!-- </li>
          <li class="nav-item">
            <a href="{{url('admin/categories')}}" class="nav-link">

              <i class="nav-icon fas fa-th"></i>             
              <p>
                Categories
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/products')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>             
              <p>
                Products
              </p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Products Details
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('admin/categories')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categories </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/products')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('order.detail.admin')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Details</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>