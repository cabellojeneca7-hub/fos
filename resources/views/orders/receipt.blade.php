<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .receipt-box { width: 100%; max-width: 500px; margin: auto; padding: 30px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-bottom: 25px; font-size: 14px; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .items-table th, .items-table td { text-align: left; padding: 12px 8px; border-bottom: 1px solid #f5f5f5; }
        .items-table th { background-color: #fafafa; font-size: 13px; text-transform: uppercase; color: #888; }
        .financials { width: 100%; margin-top: 20px; }
        .financial-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 14px; }
        .financial-row.total { font-weight: bold; font-size: 18px; border-top: 2px solid #eee; margin-top: 10px; padding-top: 15px; }
        .payment-info { background-color: #f9fbff; padding: 15px; border-radius: 8px; margin-top: 30px; border: 1px solid #eef4ff; }
        .payment-info p { margin: 5px 0; font-size: 12px; color: #555; }
        .footer { text-align: center; margin-top: 40px; color: #aaa; font-size: 12px; }
    </style>
</head>
<body>
    <div class="receipt-box">
        <div class="header">
            <h1 style="margin:0; color: #1a56db;">Fast Food System</h1>
            <p style="margin:5px 0; color: #666;">Official Electronic Receipt</p>
        </div>

        <div class="details">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <strong>Order ID:</strong> #{{ $order->id }}<br>
                        <strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}
                    </td>
                    <td style="text-align: right;">
                        <strong>Customer:</strong> {{ $order->customer_name }}<br>
                        <strong>Status:</strong> <span style="color: #057a55;">{{ ucfirst($order->status) }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->menuItem->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-left: 60%;">
            <table style="width: 100%; font-size: 14px;">
                <tr>
                    <td style="padding: 4px 0; color: #666;">Subtotal:</td>
                    <td style="text-align: right; padding: 4px 0;">₱{{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; color: #666;">Tax (VAT 12%):</td>
                    <td style="text-align: right; padding: 4px 0;">₱{{ number_format($order->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; color: #666;">Discount:</td>
                    <td style="text-align: right; padding: 4px 0;">-₱{{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                <tr style="font-weight: bold; font-size: 16px;">
                    <td style="padding: 10px 0; border-top: 1px solid #eee;">Total:</td>
                    <td style="text-align: right; padding: 10px 0; border-top: 1px solid #eee; color: #1a56db;">₱{{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="payment-info">
            <p><strong>Payment Confirmation</strong></p>
            <p>Method: {{ $order->payment_method ?? 'N/A' }}</p>
            <p>Transaction ID: {{ $order->transaction_id ?? 'N/A' }}</p>
            <p style="font-style: italic; margin-top: 8px; color: #999;">* This is a prototype transaction.</p>
        </div>

        <div class="footer">
            <p>Thank you for dining with us!</p>
            <p>&copy; {{ date('Y') }} Fast Food System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
