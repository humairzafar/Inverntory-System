@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Items</h2>
    
    <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Add New Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover" id="itemsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Image</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr 
                data-id="{{ $item->id }}"
                data-name="{{ $item->name }}"
                data-amount="{{ $item->amount }}"
                data-brand-id="{{ $item->brand_id }}"
                data-model-id="{{ $item->device_model_id }}"
            >
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->brand->name ?? '-' }}</td>
                <td>{{ $item->model->name ?? '-' }}</td>
               <td>
                    @if($item->image)
                        <img src="{{ asset('uploads/items/' . $item->image) }}" width="100" alt="Item Image">
                    @else
                        <span>No Image</span>
                    @endif
                </td>

                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <button class="delete-item btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $items->links() }}
</div>
@endsection

@push('scripts')
<script>
$(function () {
    $('.delete-item').click(function () {
        if (!confirm('Are you sure to delete this item?')) return;
        const id = $(this).closest('tr').data('id');
        $.ajax({
            url: '/items/' + id,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                location.reload();
            },
            error: function () {
                alert('Delete failed.');
            }
        });
    });
});
</script>
@endpush
