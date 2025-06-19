@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Item</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" value="{{ old('amount', $item->amount) }}" required>
        </div>

        <div class="mb-3">
            <label>Brand</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">-- Select Brand --</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $brand->id == old('brand_id', $item->brand_id) ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Model</label>
            <select name="device_model_id" id="model_id" class="form-control">
                <option value="">-- Select Model --</option>
                @foreach($models as $model)
                    <option value="{{ $model->id }}" {{ $model->id == old('device_model_id', $item->device_model_id) ? 'selected' : '' }}>{{ $model->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.getElementById('brand_id').addEventListener('change', function() {
        let brandId = this.value;
        fetch(`/brands/${brandId}/models`)
            .then(response => response.json())
            .then(models => {
                let options = '<option value="">-- Select Model --</option>';
                models.forEach(model => {
                    options += `<option value="${model.id}">${model.name}</option>`;
                });
                document.getElementById('model_id').innerHTML = options;
            });
    });
</script>
@endsection
