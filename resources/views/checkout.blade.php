@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Checkout</h2>
    <div class="row">
        <!-- Left: Cart items -->
        <div class="col-md-6">…</div>

        <!-- Right: Form -->
        <div class="col-md-6">
            <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <!-- fields: name,email,phone,address -->

                <select id="payment-method" name="payment_method" required>
                    <option value="">-- Select --</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="stripe">Credit/Debit Card (Stripe)</option>
                </select>

                <div id="stripe-card-section" style="display:none;margin-top:1rem;">
                    <label>Card Details</label>
                    <div id="card-element" class="form-control"></div>
                    <div id="card-errors" class="text-danger"></div>
                    <input type="hidden" name="stripe_payment_method_id" id="stripe-payment-method-id">
                </div>

                <button type="submit" class="btn btn-success w-100 mt-3">Place Order</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
  const stripe = Stripe("{{ env('STRIPE_KEY') }}");
  const elements = stripe.elements();
  const card = elements.create("card");
  card.mount("#card-element");

  const form = document.getElementById("checkout-form");
  const pmSelect = document.getElementById("payment-method");
  const stripeSection = document.getElementById("stripe-card-section");
  const errDiv = document.getElementById("card-errors");
  const pmInput = document.getElementById("stripe-payment-method-id");

  pmSelect.onchange = () => {
    stripeSection.style.display = pmSelect.value === "stripe" ? "block" : "none";
  };

  form.onsubmit = async e => {
    if (pmSelect.value !== "stripe") return; // cod flows

    e.preventDefault();
    const {error, paymentMethod} = await stripe.createPaymentMethod({
      type: "card", card: card
    });
    if (error) {
      errDiv.textContent = error.message;
    } else {
      pmInput.value = paymentMethod.id;
      form.submit();
    }
  };
</script>
@endsection
