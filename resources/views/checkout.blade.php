@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">🧾 Checkout</h2>

    <div class="row">
        <!-- Left: Cart Items -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Your Selected Items</h5>
                </div>
                <div class="card-body">
                    @php $total = 0; @endphp
                    @foreach ($cart as $item)
                        @php $itemTotal = $item['quantity'] * $item['amount']; $total += $itemTotal; @endphp
                        <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                            <img src="{{ asset('uploads/items/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-thumbnail me-3" style="width: 70px; height: 70px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item['name'] }}</h6>
                                <small>Qty: {{ $item['quantity'] }} × {{ number_format($item['amount'], 2) }}</small>
                            </div>
                            <strong>{{ number_format($itemTotal, 2) }}</strong>
                        </div>
                    @endforeach

                    <div class="mt-3 text-end">
                        <h5>Total: {{ number_format($total, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Checkout Form -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Billing Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Shipping Address</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
    <label for="payment_method" class="form-label">Payment Method</label>
    <select name="payment_method" class="form-select" required>
        <option value="">-- Select Payment Method --</option>
        <option value="cod">Cash on Delivery</option>
        <option value="stripe">Credit/Debit Card (Stripe)</option>
    </select>
</div>


                        <button type="submit" class="btn btn-success w-100">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
