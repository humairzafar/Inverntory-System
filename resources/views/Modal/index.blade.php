@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Models</h2>
        <a href="{{ route('modal.create') }}" class="btn btn-primary">Add New Model</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Items Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($models as $model)
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->name }}</td>
                    <td>{{ $model->brand->name ?? 'N/A' }}</td>
                    <td>{{ $model->items->count() }}</td>
                    <td>
                        <a href="{{ route('modal.edit', $model->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('modal.destroy', $model->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this model?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No models found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
