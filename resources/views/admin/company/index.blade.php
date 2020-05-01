@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Company List</div>

                <div class="card-body">
                    @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <a style="margin-bottom:5px;" href="{{ route('companies.create') }}" class="btn btn-sm btn-primary">Add Company</a>
 
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Address</td>
                                <td>Website</td>
                                <td class="text-center">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($companies) != 0) 
                                @foreach($companies as $company)
                                <tr>
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->address }}</td>
                                    <td>{{ $company->website }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('companies.edit', $company->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('companies.destroy', $company->id)}}" method="post" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="5">No data available</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
