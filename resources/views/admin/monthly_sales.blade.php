@extends('layouts.master')
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

  /* ── All scoped under .rpt so nothing leaks into admin layout ── */
  .rpt {
    --ink:      #0f1923;
    --ink-soft: #3a4553;
    --ink-mute: #8a97a8;
    --warm:     #f2ede4;
    --gold:     #c8a96e;
    --gold-lt:  #e8d9bc;
    --green:    #2d6a4f;
    --green-lt: #d8f3dc;
    --red:      #c1121f;
    --bdr:      rgba(15,25,35,0.1);
    font-family: 'DM Sans', sans-serif;
    color: #0f1923;
  }

  /* ── Top bar ── */
  .rpt-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(15,25,35,0.1);
  }
  .rpt-topbar h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0;
    color: #0f1923;
  }
  .rpt-topbar p { font-size: 0.78rem; color: #8a97a8; margin: 3px 0 0; }
  .rpt-print-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: #0f1923;
    color: #fff;
    border: none;
    font-size: 0.76rem;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    cursor: pointer;
    transition: 0.2s;
    white-space: nowrap;
  }
  .rpt-print-btn:hover { background: #c8a96e; color: #0f1923; }

  /* ── Filter bar ── */
  .rpt-filter {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    flex-wrap: wrap;
    background: #f2ede4;
    border: 1px solid #e8d9bc;
    padding: 12px 16px;
    margin-bottom: 1.5rem;
  }
  .rpt-filter .fg { display: flex; flex-direction: column; gap: 4px; }
  .rpt-filter label {
    font-size: 0.68rem;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #8a97a8;
  }
  .rpt-filter input[type="date"] {
    padding: 7px 10px;
    border: 1px solid rgba(15,25,35,0.15);
    background: #fff;
    font-family: 'DM Mono', monospace;
    font-size: 0.8rem;
    color: #0f1923;
    outline: none;
    min-width: 140px;
  }
  .rpt-filter input[type="date"]:focus { border-color: #c8a96e; }
  .rpt-btn-go {
    padding: 7px 18px;
    background: #0f1923;
    color: #fff;
    border: none;
    font-size: 0.76rem;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    cursor: pointer;
  }
  .rpt-btn-go:hover { background: #c8a96e; color: #0f1923; }
  .rpt-btn-reset {
    padding: 7px 14px;
    background: transparent;
    color: #3a4553;
    border: 1px solid rgba(15,25,35,0.15);
    font-size: 0.76rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
  }
  .rpt-btn-reset:hover { border-color: #0f1923; color: #0f1923; }

  /* ── Summary cards ── */
  .rpt-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 1.5rem;
  }
  @media (max-width: 1280px) { .rpt-cards { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 600px)  { .rpt-cards { grid-template-columns: 1fr; } }

  .rpt-card {
    background: #fff;
    border: 1px solid rgba(15,25,35,0.1);
    border-top: 3px solid #c8a96e;
    padding: 14px 16px;
  }
  .rpt-card.g { border-top-color: #2d6a4f; }
  .rpt-card.r { border-top-color: #c1121f; }
  .rpt-card .lbl { font-size: 0.66rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #8a97a8; margin-bottom: 6px; }
  .rpt-card .val { font-family: 'Playfair Display', serif; font-size: 1.35rem; font-weight: 700; color: #0f1923; line-height: 1; }
  .rpt-card .sub { font-size: 0.7rem; color: #8a97a8; margin-top: 4px; }

  /* ── Report title (prints) ── */
  .rpt-heading {
    text-align: center;
    margin-bottom: 1rem;
    padding-bottom: 0.875rem;
    border-bottom: 2px solid #0f1923;
  }
  .rpt-heading h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-decoration: underline;
    text-underline-offset: 4px;
    margin: 0 0 4px;
    color: #0f1923;
  }
  .rpt-heading p { font-size: 0.8rem; color: #3a4553; font-family: 'DM Mono', monospace; margin: 0; }

  /* ── Table ── */
  .rpt-table-wrap {
    background: #fff;
    border: 1px solid rgba(15,25,35,0.1);
    overflow-x: auto;
    box-shadow: 0 2px 16px rgba(15,25,35,0.06);
  }
  .rpt-table { width: 100%; border-collapse: collapse; font-size: 0.78rem; }
  .rpt-table thead tr { background: #0f1923; color: #fff; }
  .rpt-table thead th {
    padding: 10px 11px;
    font-weight: 600;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    font-size: 0.68rem;
    white-space: nowrap;
    border: none;
    text-align: center;
  }
  .rpt-table thead th:first-child { text-align: left; }
  .rpt-table tbody tr { border-bottom: 1px solid rgba(15,25,35,0.06); }
  .rpt-table tbody tr:hover { background: #f2ede4; }
  .rpt-table tbody tr:last-child { border-bottom: none; }
  .rpt-table tbody td { padding: 9px 11px; text-align: center; color: #3a4553; vertical-align: middle; }
  .rpt-table tbody td:first-child { text-align: left; font-family: 'DM Mono', monospace; font-size: 0.74rem; color: #8a97a8; }
  .rpt-table tbody td.inv  { font-family: 'DM Mono', monospace; font-size: 0.74rem; font-weight: 500; color: #0f1923; }
  .rpt-table tbody td.amt  { font-weight: 600; color: #0f1923; }
  .rpt-table tbody td.grs  { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 0.86rem; color: #0f1923; }
  .rpt-table tfoot tr      { background: #0f1923; }
  .rpt-table tfoot td      { padding: 10px 11px; text-align: center; font-weight: 600; font-size: 0.78rem; border: none; color: #fff; }
  .rpt-table tfoot td:first-child { text-align: right; font-size: 0.68rem; letter-spacing: 1px; text-transform: uppercase; color: #c8a96e; }
  .rpt-table tfoot td.tgrs { font-family: 'Playfair Display', serif; font-size: 0.92rem; color: #c8a96e; }

  .tv { display: inline-block; padding: 2px 6px; font-size: 0.71rem; font-weight: 500; border-radius: 2px; }
  .tv.cs { background: #d8f3dc; color: #2d6a4f; }
  .tv.ig { background: rgba(200,169,110,0.15); color: #8a6b2a; }
  .tv.nl { color: #8a97a8; }
  .sb { display: inline-block; padding: 2px 6px; background: #f2ede4; border: 1px solid #e8d9bc; font-size: 0.68rem; font-weight: 500; color: #3a4553; }

  .rpt-empty { padding: 3rem 2rem; text-align: center; }
  .rpt-empty i { font-size: 1.8rem; color: #e8d9bc; margin-bottom: 8px; display: block; }
  .rpt-empty p { color: #8a97a8; font-size: 0.85rem; }

  @media print {
    .no-print, .rpt-filter, .rpt-cards,
    .rpt-topbar .rpt-print-btn,
    .sidebar, nav, .header, header { display: none !important; }
    .rpt { color: #000; }
    .rpt-table thead tr,
    .rpt-table tfoot tr {
      background: #1a1a1a !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>

<div class="page-wrapper">
<div class="content rpt">

  {{-- Top bar --}}
  <div class="rpt-topbar no-print">
    <div>
      <h2>Sales Report</h2>
      <p>
        {{ $from->format('d M Y') }} — {{ $to->format('d M Y') }}
        &nbsp;·&nbsp;
        {{ $records->count() }} {{ Str::plural('transaction', $records->count()) }}
      </p>
    </div>
    <button class="rpt-print-btn" onclick="window.print()">
      <i class="fa fa-print"></i> Print / Export
    </button>
  </div>

  {{-- Filter --}}
  <form method="GET" action="{{ route('reports.sales') }}" class="rpt-filter no-print">
    <div class="fg">
      <label>From</label>
      <input type="date" name="from" value="{{ request('from', $from->format('Y-m-d')) }}">
    </div>
    <div class="fg">
      <label>To</label>
      <input type="date" name="to" value="{{ request('to', $to->format('Y-m-d')) }}">
    </div>
    <button type="submit" class="rpt-btn-go">Filter</button>
    <a href="{{ route('reports.sales') }}" class="rpt-btn-reset">Reset</a>
  </form>

  {{-- Summary cards --}}
  @if($records->isNotEmpty())
  <div class="rpt-cards no-print">
    <div class="rpt-card">
      <div class="lbl">Gross Revenue</div>
      <div class="val">₹{{ number_format($totals['gross_amount'], 0) }}</div>
      <div class="sub">Including delivery</div>
    </div>
    <div class="rpt-card g">
      <div class="lbl">Total Tax</div>
      <div class="val">₹{{ number_format($totals['cgst'] + $totals['sgst'] + $totals['igst'], 0) }}</div>
      <div class="sub">CGST + SGST + IGST</div>
    </div>
    <div class="rpt-card">
      <div class="lbl">Orders</div>
      <div class="val">{{ $records->count() }}</div>
      <div class="sub">{{ $totals['items'] }} items sold</div>
    </div>
    <div class="rpt-card r">
      <div class="lbl">Delivery Revenue</div>
      <div class="val">₹{{ number_format($totals['delivery_cost'], 0) }}</div>
      <div class="sub">Shipping collected</div>
    </div>
  </div>
  @endif

  {{-- Printable area --}}
  <div class="rpt-heading">
    <h3>Etthnicoast Monthly Sells Reports</h3>
    <p>(From {{ $from->format('d/m/Y') }} &nbsp;To&nbsp; {{ $to->format('d/m/Y') }})</p>
  </div>

  <div class="rpt-table-wrap">
    <table class="rpt-table">
      <thead>
        <tr>
          <th style="text-align:left">Date</th>
          <th>Invoice No</th>
          <th>Amount</th>
          <th>Items</th>
          <th>Del. State</th>
          <th>1.5% CGST</th>
          <th>1.5% SGST</th>
          <th>3% IGST</th>
          <th>Del. Cost</th>
          <th>Gross Amount</th>
        </tr>
      </thead>
      <tbody>
        @forelse($records as $row)
        <tr>
          <td>{{ $row->sale_date->format('d/m/Y') }}</td>
          <td class="inv">{{ $row->invoice?->invoice_number ?? '—' }}</td>
          <td class="amt">₹{{ number_format($row->amount, 2) }}</td>
          <td>{{ $row->quantity }}</td>
          <td>
            @if($row->delivery_state)
              <span class="sb">{{ $row->delivery_state }}</span>
            @else <span class="tv nl">—</span>
            @endif
          </td>
          <td>
            @if($row->cgst_amount > 0)
              <span class="tv cs">₹{{ number_format($row->cgst_amount, 2) }}</span>
            @else <span class="tv nl">—</span>
            @endif
          </td>
          <td>
            @if($row->sgst_amount > 0)
              <span class="tv cs">₹{{ number_format($row->sgst_amount, 2) }}</span>
            @else <span class="tv nl">—</span>
            @endif
          </td>
          <td>
            @if($row->igst_amount > 0)
              <span class="tv ig">₹{{ number_format($row->igst_amount, 2) }}</span>
            @else <span class="tv nl">—</span>
            @endif
          </td>
          <td>
            @if($row->delivery_cost > 0)
              ₹{{ number_format($row->delivery_cost, 2) }}
            @else <span class="tv nl">—</span>
            @endif
          </td>
          <td class="grs">₹{{ number_format($row->gross_amount, 2) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="10">
            <div class="rpt-empty">
              <i class="fa-regular fa-folder-open"></i>
              <p>No records found for the selected period.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>

      @if($records->isNotEmpty())
      <tfoot>
        <tr>
          <td colspan="2">Totals</td>
          <td>₹{{ number_format($totals['amount'], 2) }}</td>
          <td>{{ $totals['items'] }}</td>
          <td>—</td>
          <td>₹{{ number_format($totals['cgst'], 2) }}</td>
          <td>₹{{ number_format($totals['sgst'], 2) }}</td>
          <td>₹{{ number_format($totals['igst'], 2) }}</td>
          <td>₹{{ number_format($totals['delivery_cost'], 2) }}</td>
          <td class="tgrs">₹{{ number_format($totals['gross_amount'], 2) }}</td>
        </tr>
      </tfoot>
      @endif
    </table>
  </div>

</div>{{-- /content --}}
</div>{{-- /page-wrapper --}}

@endsection