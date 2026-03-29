<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Label — {{ $order->order_code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #fff; }

        /* ── Label container — 10cm × 15cm typical parcel label ── */
        .label {
            width: 10cm;
            min-height: 5cm;
            border: 2px solid #000;
            padding: 10px 12px;
            page-break-after: always;
            margin: 0 auto 20px;
        }

        .label-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid #000;
            padding-bottom: 6px;
            margin-bottom: 6px;
        }
        .brand {
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .order-id {
            font-size: 11px;
            font-weight: 700;
            text-align: right;
        }
        .order-date { font-size: 9px; color: #555; }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            border-bottom: 1px dotted #ccc;
            font-size: 11px;
        }
        .item-row:last-of-type { border-bottom: none; }
        .item-name { font-weight: 700; flex: 1; }
        .item-sku  { color: #555; font-size: 10px; margin: 0 8px; }
        .item-qty  { font-weight: 700; white-space: nowrap; }

        .label-footer {
            margin-top: 8px;
            border-top: 1px solid #000;
            padding-top: 6px;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }
        .thank-you {
            font-size: 9px;
            text-align: center;
            color: #555;
            margin-top: 4px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .label { border: 2px solid #000; margin: 0 auto; }
        }
    </style>
</head>
<body>

{{-- Print button (hidden on print) --}}
<div class="no-print" style="text-align:center;padding:16px;">
    <button onclick="window.print()"
            style="padding:10px 28px;background:#07203F;color:#fff;border:none;cursor:pointer;font-size:14px;margin-right:8px;">
        🖨 Print Label
    </button>
    <button onclick="window.close()"
            style="padding:10px 20px;background:#eee;border:1px solid #ccc;cursor:pointer;font-size:14px;">
        Close
    </button>
    <p style="margin-top:8px;font-size:12px;color:#888;">Cut and paste this label on the product parcel</p>
</div>

{{-- One label per order item --}}
@foreach($order->items as $item)
    @php $product = $item->product; @endphp
    <div class="label">
        <div class="label-header">
            <div class="brand">Etthnicoast</div>
            <div class="order-id">
                {{ $order->order_code }}<br>
                <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <div class="item-row">
            <span class="item-name">{{ $product?->base_name ?? 'Product' }}</span>
            <span class="item-sku">{{ $product?->product_code }}</span>
            <span class="item-qty">Qty: {{ $item->quantity }}</span>
        </div>

        @if($item->variant)
            <div style="font-size:10px;color:#555;padding:3px 0;">
                Finish: {{ $item->variant->finish }}
            </div>
        @endif

        <div class="label-footer">
            <span>₹{{ number_format($item->total_price) }}</span>
            <span>Fragile — Handle with care</span>
        </div>
        <div class="thank-you">Thank you for shopping with us!</div>
    </div>
@endforeach

<script>
    // Auto-open print dialog
    window.addEventListener('load', () => window.print());
</script>
</body>
</html>