@extends('layouts.admin')
@section('content')
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
          </button>
        </div>
      </div>
      <div class="container">
      @if ($errors->any())
            <div class="alert alert-danger alert-close">
            <button class="alert-btn-close">
                <i class="fad fa-times"></i>
            </button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <form action="{{ route('admin.carousel') }}" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="row">
                <div class="col-md-12 mb-4">
                    <h2>Slide 1</h2>
                    <div class="mb-3">
                        <label for="" class="form-label">Link</label>
                        <input type="text" name="link[1]" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">File</label>
                        <input type="file" name="image[1]" class="form-control" id="">
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <h2>Slide 2</h2>
                    <div class="mb-3">
                        <label for="" class="form-label">Link</label>
                        <input type="text" name="link[2]" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">File</label>
                        <input type="file" name="image[2]" class="form-control" id="">
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <h2>Slide 3</h2>
                    <div class="mb-3">
                        <label for="" class="form-label">Link</label>
                        <input type="text" name="link[3]" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">File</label>
                        <input type="file" name="image[3]" class="form-control" id="">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </form>

      </div>
      </div>
 @endsection
