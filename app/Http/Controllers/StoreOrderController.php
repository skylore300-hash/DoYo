<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StoreOrderController extends Controller
{
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $requestedItems = collect($request->validated('items'))->keyBy('product_id');
        $products = Product::query()
            ->whereIn('id', $requestedItems->keys())
            ->where('published', true)
            ->get()
            ->groupBy('seller_id');

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Aucun produit vendeur valide dans ce panier.'], 422);
        }

        $orders = DB::transaction(function () use ($products, $requestedItems): array {
            return $products->map(function ($sellerProducts, $sellerId) use ($requestedItems): int {
                $total = 0;
                $items = [];

                foreach ($sellerProducts as $product) {
                    $quantity = (int) $requestedItems->get($product->id)['quantity'];
                    $discountedPrice = (float) $product->price * (1 - ((int) $product->discount_percent / 100));
                    $total += $discountedPrice * $quantity;
                    $items[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'unit_price' => $product->price,
                        'discount_percent' => $product->discount_percent,
                        'quantity' => $quantity,
                    ];
                }

                $order = Order::create(['seller_id' => $sellerId, 'status' => 'pending', 'total' => $total]);
                $order->items()->createMany($items);

                return $order->id;
            })->values()->all();
        });

        return response()->json(['order_ids' => $orders]);
    }
}
