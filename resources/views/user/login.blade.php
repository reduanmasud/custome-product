@extends('layouts.default')

@section('content')

<div class="container">
<h2 class="mt-3">Login</h2>
    <div class="row">
        <div class="col-md-6 p-3">

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            
            <form method="post" action="{{route('login')}}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-danger">Login</button>
            </form>

        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>

@stop