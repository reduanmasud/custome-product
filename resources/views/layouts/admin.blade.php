<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Dashboard Template · Bootstrap v5.3</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="{{URL::asset('admin/dashboard.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  </head>
  <body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Company name</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="#">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
          <ul class="nav flex-column">
              <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{route('admin./')}}">
                      <span data-feather="home" class="align-text-bottom"></span>
                      Dashboard
                  </a>
              </li>
          </ul>
          <h6
              class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
              <span>Products</span>
              <a class="link-secondary" href="#" aria-label="Add a new report">
                  <span data-feather="shopping-cart" class="align-text-bottom"></span>
              </a>
          </h6>
          <ul class="nav flex-column mb-2">
              <li class="nav-item">
                  <a class="nav-link" href="{{route('admin.product.all')}}">
                      <span data-feather="arrow-right" class="align-text-bottom"></span>
                      All Products
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.product.add') }}">
                      <span data-feather="arrow-right" class="align-text-bottom"></span>
                      Add Products
                  </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('product.category') }}">
                    <span data-feather="arrow-right" class="align-text-bottom"></span>
                    Category
                </a>
            </li>
              {{-- <li class="nav-item">
                  <a class="nav-link" href="product/add-customize-product.html">
                      <span data-feather="arrow-right" class="align-text-bottom"></span>
                      Add Customizable Products
                  </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="product/single-product-view.html">
                    <span data-feather="arrow-right" class="align-text-bottom"></span>
                    Single Product Page
                </a>
            </li> --}}
          </ul>

          <h6
              class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
              <span>Other Settings</span>
              <a class="link-secondary" href="#" aria-label="Add a new report">
                  <span data-feather="plus-circle" class="align-text-bottom"></span>
              </a>
          </h6>
          <ul class="nav flex-column mb-2">
              <li class="nav-item">
                  <a class="nav-link" href="{{route('admin.carousel')}}">
                      <span data-feather="file-text" class="align-text-bottom"></span>
                      Carousel settings
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">
                      <span data-feather="file-text" class="align-text-bottom"></span>
                      Last quarter
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">
                      <span data-feather="file-text" class="align-text-bottom"></span>
                      Social engagement
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">
                      <span data-feather="file-text" class="align-text-bottom"></span>
                      Year-end sale
                  </a>
              </li>
          </ul>
      </div>
  </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        @yield('content')
    </main>
  </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>


      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
      <script src="{{URL::asset('admin/dashboard.js')}}"></script>
  </body>
</html>
