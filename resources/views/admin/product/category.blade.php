@extends('layouts.admin')
@section('content')


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<div class="container">


    <h2 class="mt-2">Category</h2>
    <div class="row">
        <div class="col-md-6 p-3">




            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>CID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>E||D||U</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>CID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>

        </div>

        <div class="col-md-6">
            <form method="post" action="{{route('product.category')}}">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <h3>Add Category</h3>
                @csrf
                <div class="mb-3">
                    <label for="category_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="category_name" name="name">
                </div>
                <div class="mb-3">
                    <label for="category_description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="category_description" name="description">
                </div>
                <button type="submit" class="btn btn-success">Add Category</button>
            </form>
        </div>

    </div>
</div>




<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
@endsection
