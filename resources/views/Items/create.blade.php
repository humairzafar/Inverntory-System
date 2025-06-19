@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Item</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Brand</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">-- Select Brand --</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Model</label>
            <select name="model_id" id="model_id" class="form-control">
                <option value="">-- Select Model --</option>
            </select>
        </div>
        <div class="mb-3">
            <input type="file" name="image" id="image" accept="image/*">
</div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $('#brand_id').on('change', function () {
        let brandId = $(this).val();
        $('#model_id').html('<option value="">Loading...</option>');
        $.get('/brands/' + brandId + '/models', function (models) {
            let options = '<option value="">-- Select Model --</option>';
            models.forEach(model => {
                options += `<option value="${model.id}">${model.name}</option>`;
            });
            $('#model_id').html(options);
        });
    });
</script>
@endpush
