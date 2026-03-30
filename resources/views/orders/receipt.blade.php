<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; }
        .receipt-box { width: 100%; max-width: 400px; margin: auto; padding: 20px; border: 1px solid #eee; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th, .items-table td { text-align: left; padding: 8px; border-bottom: 1px solid #eee; }
        .total { text-align: right; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="receipt-box">
        <div class="header">
            <h2>Fast Food System</h2>
            <p>Order #{{ $order->id }}</p>
            <p>{{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>

        <div class="details">
            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->menuItem->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Total: ₱{{ number_format($order->total, 2) }}
        </div>

        <div class="header" style="margin-top: 30px;">
            <p>Thank you for your order!</p>
        </div>
    </div>
</body>
</html>