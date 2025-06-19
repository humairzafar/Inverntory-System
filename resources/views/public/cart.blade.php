@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-dark"><i class="bi bi-cart4"></i> Your Cart</h1>

    @if (count($cart) > 0)
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($cart as $id => $item)
                                @php 
                                    $itemTotal = $item['quantity'] * $item['amount']; 
                                    $total += $itemTotal; 
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('uploads/items/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-thumbnail rounded" width="80" height="80">

                                    </td>
                                    <td><strong>{{ $item['name'] }}</strong></td>
                                    <td>
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm" style="width: 80px;">
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    </td>
                                    <td>{{ number_format($item['amount'], 2) }}</td>
                                    <td><strong>{{ number_format($itemTotal, 2) }}</strong></td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this item?')">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-link text-decoration-none">&larr; Continue Shopping</a>
            <h4 class="mb-0 text-dark">Total: {{ number_format($total, 2) }}</h4>
            <!--  -->
        </div>
    @else
        <div class="alert alert-warning mt-4" role="alert">
            Your cart is empty. <a href="{{ route('home') }}" class="alert-link">Start shopping</a>.
        </div>
    @endif
    <div>
    <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">
        Proceed to Checkout
    </a>
</div>
</div>
@endsection
