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

        return view('seller.dashboard', [
            'products' => Product::query()->where('seller_id', $request->user()->id)->latest()->get(),
        ]);
    }
}
