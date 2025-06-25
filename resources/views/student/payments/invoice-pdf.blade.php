<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $payment->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details th,
        .invoice-details td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .invoice-details th {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invoice</h1>
            <p>Invoice #{{ $payment->invoice_number }}</p>
            <p>Date: {{ $payment->payment_date->format('M d, Y') }}</p>
        </div>

        <div class="invoice-details">
            <h2>Bill To</h2>
            <p>{{ Auth::user()->name }}</p>
            <p>{{ Auth::user()->email }}</p>

            <h2>Course Details</h2>
            <p>Course: {{ $payment->enrollment->course->title }}</p>
            <p>Instructor: {{ $payment->enrollment->course->instructor->name }}</p>

            <h2>Payment Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Course Enrollment: {{ $payment->enrollment->course->title }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="total">
                <p>Total: ${{ number_format($payment->amount, 2) }}</p>
            </div>

            <h2>Payment Method</h2>
            <p>Method: {{ ucfirst($payment->payment_method) }}</p>
            <p>Transaction ID: {{ $payment->transaction_id }}</p>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice, no signature required.</p>
        </div>
    </div>
</body>
</html> 