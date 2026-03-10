@extends('layouts.master')
@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

  :root {
    --ink:       #0f1923;
    --ink-soft:  #3a4553;
    --ink-muted: #8a97a8;
    --cream:     #faf8f4;
    --warm:      #f2ede4;
    --gold:      #c8a96e;
    --gold-lt:   #e8d9bc;
    --green:     #2d6a4f;
    --green-lt:  #d8f3dc;
    --red:       #c1121f;
    --red-lt:    #ffe5e5;
    --border:    rgba(15,25,35,0.1);
    --shadow:    0 2px 20px rgba(15,25,35,0.07);
  }

 .report-page {
    font-family: 'DM Sans', sans-serif;
    color: var(--ink);
    background: var(--cream);
    min-height: 100vh;
    padding: 4rem 7.5rem 4rem;
}
  /* ── Top Bar ── */
  .report-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
    margin-bottom: 2rem;
  }
  .report-topbar-left h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--ink);
    margin: 0;
    letter-spacing: -0.5px;
  }
  .report-topbar-left p {
    font-size: 0.82rem;
    color: var(--ink-muted);
    margin: 4px 0 0;
    letter-spacing: 0.5px;
  }
  .btn-print {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    background: var(--ink);
    color: #fff;
    border: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    cursor: pointer;
    transition: 0.2s ease;
  }
  .btn-print:hover { background: var(--gold); color: var(--ink); }

  /* ── Filter Bar ── */
  .filter-bar {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    background: var(--warm);
    border: 1px solid var(--gold-lt);
    padding: 16px 20px;
    margin-bottom: 2.5rem;
  }
  .filter-bar .fgroup {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }
  .filter-bar label {
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--ink-muted);
  }
  .filter-bar input[type="date"] {
    padding: 8px 12px;
    border: 1px solid var(--border);
    background: #fff;
    font-family: 'DM Mono', monospace;
    font-size: 0.82rem;
    color: var(--ink);
    outline: none;
    transition: 0.2s;
  }
  .filter-bar input[type="date"]:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(200,169,110,0.15);
  }
  .btn-filter {
    padding: 8px 20px;
    background: var(--ink);
    color: #fff;
    border: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    cursor: pointer;
    transition: 0.2s;
  }
  .btn-filter:hover { background: var(--gold); color: var(--ink); }
  .btn-reset {
    padding: 8px 16px;
    background: transparent;
    color: var(--ink-soft);
    border: 1px solid var(--border);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    text-decoration: none;
    transition: 0.2s;
    display: inline-flex;
    align-items: center;
  }
  .btn-reset:hover { border-color: var(--ink); color: var(--ink); }

  /* ── Summary Cards ── */
  .summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 2.5rem;
  }
  .summary-card {
    background: #fff;
    border: 1px solid var(--border);
    padding: 18px 20px;
    position: relative;
    overflow: hidden;
  }
  .summary-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--gold);
  }
  .summary-card.green::before { background: var(--green); }
  .summary-card.red::before   { background: var(--red); }
  .summary-card .sc-label {
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--ink-muted);
    margin-bottom: 8px;
  }
  .summary-card .sc-value {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1;
  }
  .summary-card .sc-sub {
    font-size: 0.75rem;
    color: var(--ink-muted);
    margin-top: 5px;
  }

  /* ── Report Header (print title) ── */
  .report-header {
    text-align: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1.25rem;
    border-bottom: 2px solid var(--ink);
  }
  .report-header h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-decoration: underline;
    text-underline-offset: 5px;
    margin: 0 0 6px;
    color: var(--ink);
  }
  .report-header p {
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--ink-soft);
    font-family: 'DM Mono', monospace;
    margin: 0;
  }

  /* ── Table ── */
  .report-table-wrap {
    background: #fff;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow-x: auto;
  }
  .report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.82rem;
  }
  .report-table thead tr {
    background: var(--ink);
    color: #fff;
  }
  .report-table thead th {
    padding: 13px 14px;
    font-weight: 600;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    font-size: 0.72rem;
    white-space: nowrap;
    border: none;
    text-align: center;
  }
  .report-table thead th:first-child { text-align: left; }

  .report-table tbody tr {
    border-bottom: 1px solid rgba(15,25,35,0.06);
    transition: background 0.15s;
  }
  .report-table tbody tr:hover { background: var(--warm); }
  .report-table tbody tr:last-child { border-bottom: none; }

  .report-table tbody td {
    padding: 12px 14px;
    text-align: center;
    color: var(--ink-soft);
    vertical-align: middle;
  }
  .report-table tbody td:first-child {
    text-align: left;
    font-family: 'DM Mono', monospace;
    font-size: 0.78rem;
    color: var(--ink-muted);
  }
  .report-table tbody td.invoice-no {
    font-family: 'DM Mono', monospace;
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--ink);
  }
  .report-table tbody td.amount {
    font-weight: 600;
    color: var(--ink);
  }
  .report-table tbody td.gross {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--ink);
  }

  /* Tax badges */
  .tax-val {
    display: inline-block;
    padding: 3px 8px;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: 2px;
  }
  .tax-val.cgst-sgst {
    background: var(--green-lt);
    color: var(--green);
  }
  .tax-val.igst {
    background: rgba(200,169,110,0.15);
    color: #8a6b2a;
  }
  .tax-val.nil {
    color: var(--ink-muted);
  }

  /* State badge */
  .state-badge {
    display: inline-block;
    padding: 3px 8px;
    background: var(--warm);
    border: 1px solid var(--gold-lt);
    font-size: 0.72rem;
    font-weight: 500;
    letter-spacing: 0.3px;
    color: var(--ink-soft);
  }

  /* ── Totals Row ── */
  .report-table tfoot tr {
    background: var(--ink);
    color: #fff;
  }
  .report-table tfoot td {
    padding: 13px 14px;
    text-align: center;
    font-weight: 600;
    font-size: 0.82rem;
    border: none;
    color: #fff;
  }
  .report-table tfoot td:first-child {
    text-align: right;
    font-size: 0.72rem;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--gold);
    font-family: 'DM Sans', sans-serif;
  }
  .report-table tfoot td.total-gross {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--gold);
  }

  /* ── Empty State ── */
  .empty-state {
    padding: 4rem 2rem;
    text-align: center;
  }
  .empty-state i {
    font-size: 2rem;
    color: var(--gold-lt);
    margin-bottom: 12px;
    display: block;
  }
  .empty-state p {
    color: var(--ink-muted);
    font-size: 0.9rem;
    margin: 0;
  }

  /* ── Print ── */
  @media print {
    .no-print, .filter-bar, .report-topbar .btn-print,
    .summary-grid, .sidebar, nav, header { display: none !important; }
    .report-page { padding: 0; background: #fff; }
    .report-table-wrap { box-shadow: none; border: none; }
    .report-table thead tr { background: #1a1a1a !important; -webkit-print-color-adjust: exact; }
    .report-table tfoot tr { background: #1a1a1a !important; -webkit-print-color-adjust: exact; }
    .report-header { margin-bottom: 1rem; }
  }
</style>

<div class="report-page">

  {{-- Top Bar --}}
  <div class="report-topbar no-print">
    <div class="report-topbar-left">
      <h2>Sales Report</h2>
      <p>{{ $from->format('d M Y') }} — {{ $to->format('d M Y') }} &nbsp;·&nbsp; {{ $records->count() }} {{ Str::plural('transaction', $records->count()) }}</p>
    </div>
    <button class="btn-print" onclick="window.print()">
      <i class="fa fa-print"></i> Print / Export
    </button>
  </div>

  {{-- Filter Bar --}}
  <form method="GET" class="filter-bar no-print">
    <div class="fgroup">
      <label>From</label>
      <input type="date" name="from" value="{{ request('from', $from->format('Y-m-d')) }}">
    </div>
    <div class="fgroup">
      <label>To</label>
      <input type="date" name="to" value="{{ request('to', $to->format('Y-m-d')) }}">
    </div>
    <button type="submit" class="btn-filter">Filter</button>
    <a href="{{ route('reports.sales') }}" class="btn-reset">Reset</a>
  </form>

  {{-- Summary Cards --}}
  @if($records->isNotEmpty())
  <div class="summary-grid no-print">
    <div class="summary-card">
      <div class="sc-label">Gross Revenue</div>
      <div class="sc-value">₹{{ number_format($totals['gross_amount'], 0) }}</div>
      <div class="sc-sub">Total including delivery</div>
    </div>
    <div class="summary-card green">
      <div class="sc-label">Total Tax Collected</div>
      <div class="sc-value">₹{{ number_format($totals['cgst'] + $totals['sgst'] + $totals['igst'], 0) }}</div>
      <div class="sc-sub">CGST + SGST + IGST</div>
    </div>
    <div class="summary-card">
      <div class="sc-label">Orders</div>
      <div class="sc-value">{{ $records->count() }}</div>
      <div class="sc-sub">{{ $totals['items'] }} total items sold</div>
    </div>
    <div class="summary-card red">
      <div class="sc-label">Delivery Revenue</div>
      <div class="sc-value">₹{{ number_format($totals['delivery_cost'], 0) }}</div>
      <div class="sc-sub">Shipping charges collected</div>
    </div>
  </div>
  @endif

  {{-- Printable Report Area --}}
  <div id="reportArea">

    <div class="report-header">
      <h3>Etthnicoast Monthly Sells Reports</h3>
      <p>(From {{ $from->format('d/m/Y') }} &nbsp;To&nbsp; {{ $to->format('d/m/Y') }})</p>
    </div>

    <div class="report-table-wrap">
      <table class="report-table">
        <thead>
          <tr>
            <th style="text-align:left; min-width:90px;">Date</th>
            <th style="min-width:160px;">Invoice No</th>
            <th style="min-width:100px;">Amount</th>
            <th style="min-width:70px;">Items'</th>
            <th style="min-width:120px;">Del. States</th>
            <th style="min-width:90px;">1.5% CGST</th>
            <th style="min-width:90px;">1.5% SGST</th>
            <th style="min-width:90px;">3% IGST</th>
            <th style="min-width:100px;">Delivery Cost</th>
            <th style="min-width:130px;">Gross Sells Amount</th>
          </tr>
        </thead>
        <tbody>
          @forelse($records as $row)
          <tr>
            <td>{{ $row->sale_date->format('d/m/Y') }}</td>
            <td class="invoice-no">{{ $row->invoice?->invoice_number ?? '—' }}</td>
            <td class="amount">₹{{ number_format($row->amount, 2) }}</td>
            <td>{{ $row->quantity }}</td>
            <td>
              @if($row->delivery_state)
                <span class="state-badge">{{ $row->delivery_state }}</span>
              @else
                <span class="tax-val nil">—</span>
              @endif
            </td>
            <td>
              @if($row->cgst_amount > 0)
                <span class="tax-val cgst-sgst">₹{{ number_format($row->cgst_amount, 2) }}</span>
              @else
                <span class="tax-val nil">—</span>
              @endif
            </td>
            <td>
              @if($row->sgst_amount > 0)
                <span class="tax-val cgst-sgst">₹{{ number_format($row->sgst_amount, 2) }}</span>
              @else
                <span class="tax-val nil">—</span>
              @endif
            </td>
            <td>
              @if($row->igst_amount > 0)
                <span class="tax-val igst">₹{{ number_format($row->igst_amount, 2) }}</span>
              @else
                <span class="tax-val nil">—</span>
              @endif
            </td>
            <td>
              @if($row->delivery_cost > 0)
                ₹{{ number_format($row->delivery_cost, 2) }}
              @else
                <span class="tax-val nil">—</span>
              @endif
            </td>
            <td class="gross">₹{{ number_format($row->gross_amount, 2) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="10">
              <div class="empty-state">
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
            <td colspan="2" style="text-align:right;">Total</td>
            <td>₹{{ number_format($totals['amount'], 2) }}</td>
            <td>{{ $totals['items'] }}</td>
            <td>—</td>
            <td>₹{{ number_format($totals['cgst'], 2) }}</td>
            <td>₹{{ number_format($totals['sgst'], 2) }}</td>
            <td>₹{{ number_format($totals['igst'], 2) }}</td>
            <td>₹{{ number_format($totals['delivery_cost'], 2) }}</td>
            <td class="total-gross">₹{{ number_format($totals['gross_amount'], 2) }}</td>
          </tr>
        </tfoot>
        @endif
      </table>
    </div>

  </div>{{-- end reportArea --}}

</div>{{-- end report-page --}}

@endsection