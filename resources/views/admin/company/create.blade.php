@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-6 offset-md-1">
            <div class="card">
                <div class="card-header">Create New Company</div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form method="post" action="{{ route('companies.store') }}">
                        @csrf
                        <div class="form-group">    
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name"/>
                        </div>

                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" name="address"/>
                        </div>

                        <div class="form-group">
                            <label for="website">Website:</label>
                            <input type="text" class="form-control" name="website"/>
                        </div>

                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{ route('companies.index') }}" type="button" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
