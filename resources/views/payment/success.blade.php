@extends('layouts.app')

@section('content')
<style>
    .success-container {
        max-width: 600px;
        margin: 60px auto;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        text-align: center;
    }

    .success-icon {
        font-size: 60px;
        color: #28a745;
        margin-bottom: 20px;
    }

    .success-heading {
        font-size: 28px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .success-text {
        color: #555;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .order-summary {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .order-summary p {
        margin: 5px 0;
        font-weight: 500;
    }

    .btn-home {
        padding: 10px 25px;
        font-size: 16px;
        border-radius: 30px;
    }
</style>

<div class="success-container">
    <div class="success-icon">
        <i class="bi bi-check-circle-fill"></i> <!-- Bootstrap icon -->
    </div>
    <h2 class="success-heading">Payment Successful!</h2>
    <p class="success-text">Thank you for your purchase. Your order has been placed successfully.</p>

    <div class="order-summary">
        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
        <p><strong>Name:</strong> {{ $order->name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Total Paid:</strong> ${{ number_format($order->total, 2) }}</p>
        <p><strong>Status:</strong> <span class="text-success">Paid</span></p>
    </div>
    <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-outline-primary mt-3">Download Invoice</a>


    <a href="{{ route('home') }}" class="btn btn-success btn-home">Continue Shopping</a>
</div>
@endsection
