@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Items</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
        @foreach($items as $item)
            <div style="border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
                <img src="{{ asset('uploads/items/' . $item->image) }}" width="100%" style="max-height: 150px; object-fit: cover;">
                <h3>{{ $item->name }}</h3>
                <p><strong>Price:</strong> ${{ number_format($item->amount, 2) }}</p>
                <p><strong>Brand:</strong> {{ $item->brand->name ?? '-' }}</p>
                <p><strong>Model:</strong> {{ $item->model->name ?? '-' }}</p>

                <form action="{{ route('add.to.cart', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit" style="padding: 8px 12px; background-color: #28a745; color: #fff; border: none; border-radius: 5px;">
                        Add to Cart
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
