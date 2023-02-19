<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Custom Print</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        @can('only_admin')
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('admin./') }}">Dashboard</a>
          </li>
        {{-- <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ route('product.add') }}">Add Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="">User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ route('product.category') }}">Category</a>
        </li> --}}

        @endcan
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li> -->
      </ul>

      <ul class="d-flex navbar-nav">

      @auth
      <li class="nav-item"><span class="nav-link">{{Auth::user()->name}}</span></li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Profile</a>
      </li>
      <li class="nav-item">
        <form action="{{route('logout')}}" method="post">
          @csrf
          <a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
        </form>
      </li>
      @else
        <li class="nav-item">
        <a class="nav-link" href="{{ route('user.login') }}">Login</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('user.signup') }}">Signup</a>
        </li>
      @endauth

      </ul>

    </div>
  </div>
</nav>
