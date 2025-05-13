<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Custom Print Admin Dashboard - Manage products, categories, orders and more">
    <meta name="author" content="Custom Print">
    <title>Custom Print Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template -->
    <link href="{{URL::asset('admin/dashboard.css')}}" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <style>
      .admin-brand-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
      }

      .sidebar {
        background-color: #f8f9fc;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
      }

      .sidebar .nav-link {
        color: #5a5c69;
        font-weight: 500;
        padding: 0.75rem 1rem;
        border-radius: 0.35rem;
        margin: 0.2rem 0;
      }

      .sidebar .nav-link:hover {
        background-color: #eaecf4;
      }

      .sidebar .nav-link.active {
        color: #fff;
        background-color: #4e73df;
      }

      .sidebar .nav-link i {
        margin-right: 0.5rem;
      }

      .sidebar-heading {
        color: #b7b9cc;
        font-weight: 800;
        font-size: 0.65rem;
        letter-spacing: 0.13rem;
      }

      .topbar {
        height: 4.375rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
      }

      .dropdown-menu {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: 1px solid #e3e6f0;
      }

      .dropdown-item:active {
        background-color: #4e73df;
      }

      .user-dropdown .dropdown-toggle::after {
        display: none;
      }

      .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: none;
        border-radius: 0.35rem;
      }

      .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
      }
    </style>
  </head>
  <body class="bg-light">

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Brand -->
  <a class="navbar-brand d-flex align-items-center justify-content-center" href="/">
    <div class="sidebar-brand-icon">
      <i class="fas fa-store text-primary"></i>
    </div>
    <div class="sidebar-brand-text mx-3 text-primary fw-bold">Custom Print Admin</div>
  </a>

  <!-- Topbar Search -->
  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search ms-4">
    <div class="input-group">
      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button">
          <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div>
  </form>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ms-auto">
    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
      </a>
      <!-- Dropdown - Messages -->
      <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
        <form class="form-inline mr-auto w-100 navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter bg-danger">3+</span>
      </a>
      <!-- Dropdown - Alerts -->
      <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header bg-primary text-white">
          Alerts Center
        </h6>
        <a class="dropdown-item d-flex align-items-center" href="#">
          <div class="mr-3">
            <div class="icon-circle bg-primary">
              <i class="fas fa-file-alt text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">Today</div>
            <span class="fw-bold">New orders have been received!</span>
          </div>
        </a>
        <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
      </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow user-dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small me-2">{{ Auth::user()->name }}</span>
        <img class="img-profile rounded-circle" width="32" height="32" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=ffffff">
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="{{ route('profile.edit') }}">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400 me-2"></i>
          Profile
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400 me-2"></i>
          Settings
        </a>
        <div class="dropdown-divider"></div>
        <form action="{{route('logout')}}" method="post">
          @csrf
          <button type="submit" class="dropdown-item">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 me-2"></i>
            Logout
          </button>
        </form>
      </div>
    </li>
  </ul>
</nav>
<!-- End of Topbar -->

<!-- Page Wrapper -->
<div id="wrapper">
  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin./')}}">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-store"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Custom Print</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin./') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin./')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Products
    </div>

    <!-- Nav Item - Products Menu -->
    <li class="nav-item {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
      <a class="nav-link {{ request()->routeIs('admin.product.*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts" aria-expanded="{{ request()->routeIs('admin.product.*') ? 'true' : 'false' }}" aria-controls="collapseProducts">
        <i class="fas fa-fw fa-box"></i>
        <span>Products</span>
      </a>
      <div id="collapseProducts" class="collapse {{ request()->routeIs('admin.product.*') ? 'show' : '' }}" aria-labelledby="headingProducts" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Product Management:</h6>
          <a class="collapse-item {{ request()->routeIs('admin.product.all') ? 'active' : '' }}" href="{{route('admin.product.all')}}">All Products</a>
          <a class="collapse-item {{ request()->routeIs('admin.product.add') ? 'active' : '' }}" href="{{ route('admin.product.add') }}">Add Product</a>
          <a class="collapse-item {{ request()->routeIs('admin.product.category') ? 'active' : '' }}" href="{{ route('admin.product.category') }}">Categories</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Orders -->
    <li class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.orders')}}">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Orders</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Settings
    </div>

    <!-- Nav Item - Carousel -->
    <li class="nav-item {{ request()->routeIs('admin.carousel') ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.carousel')}}">
        <i class="fas fa-fw fa-images"></i>
        <span>Carousel Settings</span>
      </a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-users"></i>
        <span>User Management</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle">
        <i class="fas fa-angle-left"></i>
      </button>
    </div>
  </ul>
  <!-- End of Sidebar -->

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
      <!-- Begin Page Content -->
      <div class="container-fluid mt-4">
        @yield('content')
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; Custom Print {{ date('Y') }}</span>
        </div>
      </div>
    </footer>
    <!-- End of Footer -->
  </div>
  <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
  crossorigin="anonymous"></script>

<!-- Core plugin JavaScript-->
<script src="https://cdn.jsdelivr.net/npm/jquery-easing@0.0.1/dist/jquery.easing.1.3.umd.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
  integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
  crossorigin="anonymous"></script>

<!-- Custom scripts for all pages-->
<script>
  // Toggle the side navigation
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');

    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', event => {
        event.preventDefault();
        document.body.classList.toggle('sidebar-toggled');
        document.querySelector('.sidebar').classList.toggle('toggled');

        if (document.querySelector('.sidebar').classList.contains('toggled')) {
          document.querySelector('.sidebar .collapse').classList.remove('show');
        }
      });
    }

    // Close any open menu accordions when window is resized below 768px
    window.addEventListener('resize', () => {
      if (window.innerWidth < 768) {
        document.querySelector('.sidebar .collapse').classList.remove('show');
      }
    });

    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    document.body.querySelector('.sidebar').addEventListener('mousewheel', function(e) {
      if (window.innerWidth > 768) {
        const delta = e.wheelDelta || -e.detail;
        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
        e.preventDefault();
      }
    });

    // Scroll to top button appear
    document.addEventListener('scroll', function() {
      const scrollToTop = document.body.querySelector('.scroll-to-top');

      if (scrollToTop) {
        if (window.pageYOffset > 100) {
          scrollToTop.style.display = "block";
        } else {
          scrollToTop.style.display = "none";
        }
      }
    });
  });
</script>

<!-- Initialize Font Awesome -->
<script>
  // This is needed if you're using the self-hosted version of Font Awesome
  // window.FontAwesomeConfig = { autoReplaceSvg: 'nest' }
</script>
</body>
</html>
