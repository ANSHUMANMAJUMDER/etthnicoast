<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #111; background: #fff; }

        .invoice-wrap {
            max-width: 800px;
            margin: 0 auto;
            padding: 32px;
            border: 1px solid #ddd;
        }

        /* ── Header ── */
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 3px solid #07203F;
        }
        .brand-block .brand-name {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #07203F;
        }
        .brand-block .brand-tagline {
            font-size: 10px;
            color: #888;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 3px;
        }
        .inv-meta { text-align: right; }
        .inv-meta .inv-title {
            font-size: 20px;
            font-weight: 700;
            color: #07203F;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .inv-meta table { margin-top: 6px; margin-left: auto; }
        .inv-meta td { padding: 2px 0 2px 16px; font-size: 12px; }
        .inv-meta td:first-child { color: #888; }
        .inv-meta td:last-child { font-weight: 700; }

        /* ── Bill to / Ship to ── */
        .addresses {
            display: flex;
            gap: 40px;
            margin-bottom: 28px;
        }
        .address-block { flex: 1; }
        .address-block .block-title {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 6px;
            font-weight: 700;
        }
        .address-block .name { font-weight: 700; font-size: 14px; margin-bottom: 3px; }
        .address-block p { font-size: 12px; color: #444; line-height: 1.6; }

        /* ── Items table ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .items-table thead tr {
            background: #07203F;
            color: #fff;
        }
        .items-table thead th {
            padding: 10px 12px;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 700;
            text-align: left;
        }
        .items-table thead th.right { text-align: right; }
        .items-table tbody tr { border-bottom: 1px solid #eee; }
        .items-table tbody tr:nth-child(even) { background: #fafafa; }
        .items-table tbody td {
            padding: 10px 12px;
            font-size: 12px;
            vertical-align: middle;
        }
        .items-table tbody td.right { text-align: right; }
        .product-name { font-weight: 700; }
        .product-sku  { font-size: 10px; color: #888; margin-top: 2px; }

        /* ── Totals ── */
        .totals-wrap {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 28px;
        }
        .totals-table { width: 280px; }
        .totals-table tr td { padding: 5px 0; font-size: 12px; }
        .totals-table tr td:last-child { text-align: right; font-weight: 700; }
        .totals-table .total-row td {
            font-size: 15px;
            font-weight: 900;
            color: #07203F;
            padding-top: 10px;
            border-top: 2px solid #07203F;
        }

        /* ── Tax summary ── */
        .tax-section {
            margin-bottom: 24px;
            background: #f8f8f8;
            border: 1px solid #eee;
            padding: 12px 16px;
        }
        .tax-section .section-title {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 8px;
            font-weight: 700;
        }
        .tax-section table { width: 100%; font-size: 11px; }
        .tax-section th { color: #888; font-weight: 700; padding: 3px 6px; text-align: left; }
        .tax-section td { padding: 3px 6px; }

        /* ── Footer ── */
        .inv-footer {
            border-top: 1px solid #ddd;
            padding-top: 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .inv-footer .terms { font-size: 10px; color: #888; line-height: 1.6; max-width: 300px; }
        .inv-footer .signature { text-align: center; }
        .inv-footer .sig-line {
            width: 160px;
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 4px;
            font-size: 10px;
            color: #555;
            text-align: center;
        }
        .watermark {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #ccc;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .invoice-wrap { border: none; padding: 16px; max-width: 100%; }
        }
    </style>
</head>
<body>

{{-- Print controls (hidden on print) --}}
<div class="no-print" style="text-align:center;padding:16px;background:#f5f5f5;border-bottom:1px solid #ddd;">
    <button onclick="window.print()"
            style="padding:10px 28px;background:#07203F;color:#fff;border:none;cursor:pointer;font-size:14px;margin-right:8px;">
        🖨 Print Invoice
    </button>
    <button onclick="window.close()"
            style="padding:10px 20px;background:#eee;border:1px solid #ccc;cursor:pointer;font-size:14px;">
        Close
    </button>
    <span style="margin-left:16px;font-size:12px;color:#888;">Admin copy — keep for records</span>
</div>

<div class="invoice-wrap">

    {{-- Header --}}
    <div class="inv-header">
        <div class="brand-block">
            <div class="brand-name">Etthnicoast</div>
            <div class="brand-tagline">Jewellery &amp; Accessories</div>
            <p style="font-size:11px;color:#555;margin-top:8px;line-height:1.6;">
                etthnicoast.com<br>
                support@etthnicoast.com
            </p>
        </div>
        <div class="inv-meta">
            <div class="inv-title">Tax Invoice</div>
            <table>
                <tr><td>Invoice No.</td><td>{{ $invoice->invoice_number }}</td></tr>
                <tr><td>Order ID</td><td>{{ $invoice->order?->order_code }}</td></tr>
                <tr><td>Date</td><td>{{ $invoice->created_at->format('d M Y') }}</td></tr>
                <tr><td>Status</td><td>{{ ucfirst($invoice->order?->status ?? 'confirmed') }}</td></tr>
            </table>
        </div>
    </div>

    {{-- Customer info --}}
    <div class="addresses">
        <div class="address-block">
            <div class="block-title">Bill To</div>
            <div class="name">{{ $invoice->order?->user?->name ?? 'Customer' }}</div>
            <p>
                {{ $invoice->order?->user?->email }}<br>
                @if($invoice->order?->user?->phone ?? $invoice->order?->user?->mobile ?? null)
                    {{ $invoice->order?->user?->phone ?? $invoice->order?->user?->mobile }}
                @endif
            </p>
        </div>
        <div class="address-block">
            <div class="block-title">Invoice Summary</div>
            <p>
                Items: {{ $invoice->items->count() }}<br>
                Invoice Total: <strong>₹{{ number_format($invoice->total_amount) }}</strong>
            </p>
        </div>
    </div>

    {{-- Items table --}}
    <table class="items-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>SKU</th>
                <th>Qty</th>
                <th class="right">Unit Price</th>
                <th class="right">CGST</th>
                <th class="right">SGST</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="product-name">{{ $item->product?->base_name ?? 'Product' }}</div>
                        @if($item->product?->product_code)
                            <div class="product-sku">{{ $item->product->product_code }}</div>
                        @endif
                    </td>
                    <td><code>{{ $item->product?->product_code ?? '—' }}</code></td>
                    <td>{{ $item->quantity }}</td>
                    <td class="right">₹{{ number_format($item->price) }}</td>
                    <td class="right">
                        @if($item->cgst)
                            {{ $item->cgst }}%<br>
                            <small style="color:#888;">₹{{ number_format($item->price * $item->quantity * $item->cgst / 100, 2) }}</small>
                        @else —
                        @endif
                    </td>
                    <td class="right">
                        @if($item->sgst)
                            {{ $item->sgst }}%<br>
                            <small style="color:#888;">₹{{ number_format($item->price * $item->quantity * $item->sgst / 100, 2) }}</small>
                        @else —
                        @endif
                    </td>
                    <td class="right"><strong>₹{{ number_format($item->total_price) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    @php
        $subtotal   = $invoice->items->sum('total_price');
        $shipping   = $invoice->total_amount - $subtotal;
        $totalCgst  = $invoice->items->sum(fn($i) => $i->price * $i->quantity * (($i->cgst ?? 0) / 100));
        $totalSgst  = $invoice->items->sum(fn($i) => $i->price * $i->quantity * (($i->sgst ?? 0) / 100));
    @endphp

    <div class="totals-wrap">
        <table class="totals-table">
            <tr><td>Subtotal</td><td>₹{{ number_format($subtotal) }}</td></tr>
            @if($totalCgst > 0)
                <tr><td>CGST</td><td>₹{{ number_format($totalCgst, 2) }}</td></tr>
            @endif
            @if($totalSgst > 0)
                <tr><td>SGST</td><td>₹{{ number_format($totalSgst, 2) }}</td></tr>
            @endif
            @if($shipping > 0)
                <tr><td>Shipping</td><td>₹{{ number_format($shipping) }}</td></tr>
            @else
                <tr><td>Shipping</td><td style="color:#27ae60;">Free</td></tr>
            @endif
            <tr class="total-row">
                <td>Grand Total</td>
                <td>₹{{ number_format($invoice->total_amount) }}</td>
            </tr>
        </table>
    </div>

    {{-- Footer --}}
    <div class="inv-footer">
        <div class="terms">
            <strong>Terms &amp; Conditions</strong><br>
            • 30-day easy exchange policy<br>
            • Goods once sold are non-refundable unless defective<br>
            • This is a computer-generated invoice
        </div>
        <div class="signature">
            <div class="sig-line">Authorised Signatory</div>
            <div style="font-size:11px;margin-top:4px;font-weight:700;">Etthnicoast</div>
        </div>
    </div>

    <div class="watermark">Etthnicoast — Admin Copy</div>

</div>

<script>
    window.addEventListener('load', () => setTimeout(() => window.print(), 400));
</script>
</body>
</html>