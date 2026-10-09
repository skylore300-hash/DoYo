<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        abort_unless($request->user()?->isSeller(), 403);

        $products = Product::query()
            ->where('seller_id', $request->user()->id)
            ->latest()
            ->get();

        return view('seller.dashboard', [
            'products' => $products,
            'orders' => $request->user()->orders()->with('items.product')->latest()->get(),
            'stats' => [
                'totalProducts' => $products->count(),
                'publishedProducts' => $products->where('published', true)->count(),
                'lowStockProducts' => $products->where('stock', '<=', 3)->count(),
                'stockUnits' => $products->sum('stock'),
                'inventoryValue' => $products->sum(
                    static fn (Product $product): float => (float) $product->price * $product->stock
                ),
            ],
        ]);
    }
}
