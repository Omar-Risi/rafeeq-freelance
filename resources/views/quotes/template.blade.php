<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Quotation #{{ $quote->id }}</title>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20mm;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f8f8;
            font-weight: bold;
        }
        tfoot td {
            background-color: #e9e9e9;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <h1>Quotation for **{{ $quote->project->name }}**</h1>
    <p><strong>Quote ID:</strong> {{ $quote->id }} | <strong>Date:</strong> {{ $quote->created_at->format('Y-m-d') }}</p>

    <table>
        <thead>
            <tr>
                <th>Item/Service</th>
                <th>Description</th>
                <th style="width: 10%; text-align: right;">Qty</th>
                <th style="width: 15%; text-align: right;">Unit Price</th>
                <th style="width: 15%; text-align: right;">Line Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp

            @foreach ($quote->items as $item)
                @php
                    // Ensure you have 'quantity' and 'price' fields on your QuoteItem model
                    $lineTotal = ($item->quantity ?? 1) * ($item->price ?? 0);
                    $total += $lineTotal;
                @endphp
                <tr>
                    <td>{{ $item->name ?? 'N/A' }}</td>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: right;">{{ $item->quantity ?? 1 }}</td>
                    <td style="text-align: right;">${{ number_format($item->price ?? 0, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($lineTotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">
                    GRAND TOTAL
                </td>
                <td style="text-align: right; font-weight: bold;">
                    ${{ number_format($total, 2) }}
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
