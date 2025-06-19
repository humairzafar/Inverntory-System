@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Model</h1>
    <form action="{{ route('modal.update', $model->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Model Name</label>
            <input type="text" name="name" id="name" value="{{ $model->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="brand_id" class="form-label">Brand</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $brand->id == $model->brand_id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('modal.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
