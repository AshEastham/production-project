<?php

namespace App\Http\Controllers\Cart;

use App\Shift\Cart;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request, Cart $cart)
    {
        $cart->sync();

        // Eager loading to reduce the amount of queries being sent to the database.
        $request->user()->load([
            'cart.product', 'cart.product.variations.stock', 'cart.stock', 'cart.type'
        ]);

        return (new CartResource($request->user()))
            ->additional([
                'meta' => $this->meta($cart, $request)
            ]);
    }

    // Json returns empty if cart has 0 quantity of items.  Used on index method and defined in Cart model.
    public function meta(Cart $cart, Request $request) {
        return [
            'empty' => $cart->isEmpty(),
            'subtotal' => $cart->subtotal()->formatted(),
            'total' => $cart->withShipping($request->shipping_method_id)->total()->formatted(),
            'changed' => $cart->hasChanged(),
        ];
    }

    public function store(CartStoreRequest $request, Cart $cart)
    {
        $cart->add($request->products);
    }

    public function update(ProductVariation $productVariation, CartUpdateRequest $request, Cart $cart)
    {
        $cart->update($productVariation->id, $request->quantity);
    }

    public function destroy(ProductVariation $productVariation, Cart $cart)
    {
        $cart->delete($productVariation->id);
    }
}
