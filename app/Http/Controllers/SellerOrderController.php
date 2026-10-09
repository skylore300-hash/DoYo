<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerOrderController extends Controller
{
    public function confirm(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->seller_id === $request->user()->id, 403);
        abort_unless($order->status === 'pending', 409);

        DB::transaction(function () use ($order): void {
            $order->load('items');

            foreach ($order->items as $item) {
                $product = $item->product()->lockForUpdate()->firstOrFail();
                abort_if($product->stock < $item->quantity, 422, "Stock insuffisant pour {$product->name}.");
                $product->decrement('stock', $item->quantity);
            }

            $order->update(['status' => 'confirmed']);
        });

        return back()->with('status', 'Achat confirmé : le stock a été mis à jour.');
    }

    public function reject(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->seller_id === $request->user()->id, 403);
        abort_unless($order->status === 'pending', 409);

        $order->update(['status' => 'no_sale']);

        return back()->with('status', 'Commande signalée comme non réalisée. Le stock reste inchangé.');
    }
}
