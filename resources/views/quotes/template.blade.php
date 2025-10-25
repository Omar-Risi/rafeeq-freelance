<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quotation #{{ $quote->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #2c3e50;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .content {
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }

        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e8e8e8;
        }

        h1 {
            font-size: 24pt;
            font-weight: 400;
            color: #1a1a1a;
            margin-bottom: 15px;
        }

        .quote-info {
            font-size: 10pt;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 10px;
        }

        .quote-details {
            display: flex;
            gap: 20px;
        }

        .client-info {
            text-align: right;
        }

        .client-label {
            color: #888;
            font-size: 9pt;
            display: block;
            margin-bottom: 3px;
        }

        .client-name {
            color: #2c3e50;
            font-size: 11pt;
        }

        .label {
            color: #888;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 10pt;
        }

        thead {
            background-color: #f7f9fc;
        }

        th {
            padding: 12px 10px;
            text-align: left;
            font-weight: 500;
            color: #555;
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:last-child td {
            border-bottom: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .item-name {
            color: #2c3e50;
        }

        .item-description {
            color: #7f8c8d;
            font-size: 9pt;
        }

        tfoot td {
            padding: 15px 10px;
            background-color: #fafafa;
            border-top: 2px solid #ddd;
        }

        .total-label {
            font-weight: 500;
            color: #2c3e50;
        }

        .total-amount {
            font-size: 14pt;
            color: #1a1a1a;
        }

        .footer {
            position: fixed;
            bottom: 30px;
            right: 40px;
            font-size: 9pt;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <h1>Quotation for {{ $quote->project->name }}</h1>
            <div class="quote-info">
                <div class="quote-details">
                    <span><span class="label">Quote ID:</span> {{ $quote->id }}</span>
                    <span><span class="label">Date:</span> {{ $quote->created_at ? $quote->created_at->format('d M Y') : 'N/A' }}</span>
                </div>
                <div class="client-info">
                    <span class="client-label">Prepared for:</span>
                    <span class="client-name">{{ $quote->project->client->name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">Item/Service</th>
                    <th style="width: 35%;">Description</th>
                    <th style="width: 10%;" class="text-right">Qty</th>
                    <th style="width: 15%;" class="text-right">Unit Price</th>
                    <th style="width: 15%;" class="text-right">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($quote->items as $item)
                    @php
                        $lineTotal = ($item->quantity ?? 1) * ($item->price ?? 0);
                        $total += $lineTotal;
                    @endphp
                    <tr>
                        <td class="item-name">{{ $item->name ?? 'N/A' }}</td>
                        <td class="item-description">{{ $item->description ?? '' }}</td>
                        <td class="text-right">{{ $item->quantity ?? 1 }}</td>
                        <td class="text-right">OMR {{ number_format($item->price ?? 0, 3) }}</td>
                        <td class="text-right">OMR {{ number_format($lineTotal, 3) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right total-label">
                        Total Amount
                    </td>
                    <td class="text-right total-amount">
                        OMR {{ number_format($total, 3) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        Generated by {{ config('app.name', 'Your App') }}
    </div>
</body>
</html>
