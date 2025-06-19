@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Brands</h1>
    <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">Add New Brand</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Items Count</th>
                <th>Models Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->items_count }}</td>
                    <td>{{ $brand->models_count }}</td>
                    <td>
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $brands->links() }}
</div>
@endsection