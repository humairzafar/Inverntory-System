<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .invoice-box {
            padding: 30px;
            font-size: 14px;
            line-height: 24px;
            color: #333;
            border: 1px solid #eee;
            margin: auto;
        }

        h2 {
            margin-bottom: 0;
        }

        .summary {
            margin-top: 30px;
        }

        .summary p {
            margin: 2px 0;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <h2>Invoice</h2>
    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>

    <hr>

    <p><strong>Billed To:</strong></p>
    <p>{{ $order->name }}</p>
    <p>{{ $order->email }}</p>
    <p>{{ $order->address }}</p>

    <hr>

    <div class="summary">
        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        <p><strong>Total Paid:</strong> ${{ number_format($order->total, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <div class="footer">
        <p>Thank you for your purchase!</p>
    </div>
</div>
</body>
</html>
