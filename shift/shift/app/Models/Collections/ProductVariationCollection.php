<?php

namespace App\Models\Collections;

use Illuminate\Database\Eloquent\Collection;

class ProductVariationCollection extends Collection
{
    public function forSyncing()
    {
        // Builds an array structure that keys products by id, and then maps the quantity into the array
        // using the id as the key, and then it's mapped to an array with the required structure.
        // essentially syncs up the orders table and the product_variation_order table.
        return $this->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product->pivot->quantity
            ];
        })->toArray();
    }
}