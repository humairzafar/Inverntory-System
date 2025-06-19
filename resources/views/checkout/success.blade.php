@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="alert alert-success text-center">
        <h4 class="mb-3">🎉 Order Placed Successfully!</h4>
        <p>Thank you! Your Cash on Delivery order has been received. We’ll contact you soon.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
</div>
@endsection
