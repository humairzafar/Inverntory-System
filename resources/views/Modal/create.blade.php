@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Model</h1>
    <form action="{{ route('modal.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Model Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="brand_id" class="form-label">Brand</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Add Model</button>
        <a href="{{ route('modal.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
