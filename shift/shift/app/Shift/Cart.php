<?php

namespace App\Shift;

use App\Models\User;
use App\Models\ShippingMethod;

class Cart 
{
    protected $user;

    protected $changed = false;

    protected $shipping;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function products()
    {
        return $this->user->cart;
    }

    public function withShipping($shippingId)
    {
        $this->shipping = ShippingMethod::find($shippingId);

        return $this;
    }

    public function add($products)
    {
        // Add a collection of products to the cart
        $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );        
    }

    public function update($productId, $quantity)
    {
        // Add a collection of products to the cart
        $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity
        ]);        
    }

    public function delete($productId) {
        $this->user->cart()->detach($productId);
    }
    
    public function sync()
    {
        $this->user->cart->each(function ($product) {
            // min quantity
            $quantity = $product->minStock($product->pivot->quantity);

            if ($quantity != $product->pivot->quantity) {
                $this->changed = true;
            }

            // update pivot
            $product->pivot->update([
                'quantity' => $quantity
            ]);
        });
    }

    public function hasChanged()
    {
        return $this->changed;
    }

    public function empty() {
        $this->user->cart()->detach();
    }

    public function isEmpty()
    {
        return $this->user->cart->sum('pivot.quantity') <= 0;
    }

    public function subtotal()
    {
        $subtotal = $this->user->cart->sum(function ($product) {
            return $product->price->amount() * $product->pivot->quantity;
        });

        return new Money($subtotal);
    }

    public function total()
    {
        if($this->shipping) {
            return $this->subtotal()->add($this->shipping->price);
        }

        return $this->subtotal();
    }
    
    protected function getStorePayload($products)
    {
        // returns a collection of products which will be added to the database.
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
            ];
        })
            ->toArray();
    }

    protected function getCurrentQuantity($productId)
    {
        // Function to get the current quantity, used in the getStorePayload method.
        if ($product = $this->user->cart->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }

        return 0;  // else return 0
    }
}