@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Brand</h1>
    <form action="{{ route('brands.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Brand Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection