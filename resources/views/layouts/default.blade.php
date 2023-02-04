<!doctype html>
<html>
<head>
   @include('includes.head')
   @yield('head_content')
</head>
<body>
<div class="container-fluid">
   <header class="row">
       @include('includes.header')
   </header>
</div>

    @yield('content')

<footer class="row">
    @include('includes.footer')
</footer>

    @yield('footer_content')
</body>
</html>