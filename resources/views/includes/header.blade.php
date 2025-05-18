<header class="site-header">
  <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
    <div class="container">
      <a class="navbar-brand" href="/">
        <i class="fas fa-tshirt me-2"></i>Custom Print
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('product*') ? 'active' : '' }}" href="{{ route('product.index') }}">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
          @can('only_admin')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin./') }}">
              <i class="fas fa-cog me-1"></i>Admin Dashboard
            </a>
          </li>
          @endcan
        </ul>

        <div class="d-flex align-items-center">
          <form class="d-none d-md-flex me-3" action="{{ route('product.index') }}" method="GET">
            <div class="input-group">
              <input class="form-control" type="search" name="search" placeholder="Search products..." aria-label="Search">
              <button class="btn btn-outline-primary" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>

          <ul class="navbar-nav">
            @auth
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a></li>
                <li><a class="dropdown-item" href="#">My Orders</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
            @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('user.login') }}">Login</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-primary ms-2" href="{{ route('user.signup') }}">Sign Up</a>
            </li>
            @endauth
            <li class="nav-item ms-3">
              <a class="nav-link position-relative" href="#">
                <i class="fas fa-shopping-cart fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  0
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>
