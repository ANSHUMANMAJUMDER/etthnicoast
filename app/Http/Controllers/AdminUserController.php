<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Wishlist;

class AdminUserController extends Controller
{
    // ── User list ─────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $q = $request->q;

        $users = User::where('role_name','etthnicoast_user')->withCount(['orders', 'wishlists'])
            ->withSum('orders', 'total_amount')
            ->when($q, fn($query) => $query->where(function ($qb) use ($q) {
                $qb->where('name',  'like', "%{$q}%")
                   ->orWhere('email','like', "%{$q}%");
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    // ── User detail (orders + wishlist + invoices) ────────────────────────
    public function show(User $user)
    {
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product.images', 'invoice.items.product'])
            ->latest()
            ->get();

        $wishlists = Wishlist::where('user_id', $user->id)
            ->with(['product.images'])
            ->latest()
            ->get();

        $invoices = Invoice::where('user_id', $user->id)
            ->with(['items.product', 'order'])
            ->latest()
            ->get();

        return view('admin.users.show', compact('user', 'orders', 'wishlists', 'invoices'));
    }

    // ── Product label print data (JSON for print popup) ───────────────────
    public function printLabel(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.users.print-label', compact('order'));
    }

    // ── Invoice print ─────────────────────────────────────────────────────
    public function printInvoice(Invoice $invoice)
    {
        $invoice->load(['items.product', 'order.user']);
        return view('admin.users.print-invoice', compact('invoice'));
    }
}