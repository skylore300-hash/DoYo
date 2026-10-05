<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = $request->user()->products()->create([
            ...$request->safe()->except('image'),
            'image_path' => $request->file('image')->store('products', 'public'),
            'published' => true,
        ]);

        return back()->with('status', "Le produit {$product->name} est publié dans la boutique.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        abort_unless($product->seller_id === auth()->id(), 403);

        Storage::disk('public')->delete($product->image_path);
        $product->delete();

        return back()->with('status', 'Le produit a été retiré de la boutique.');
    }
}
