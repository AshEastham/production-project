<?php

namespace App\Http\Resources;

use App\Http\Resources\AddressResource;
use App\Http\Resources\ShippingMethodResource;
use App\Http\Resources\ProductVariationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'subtotal' => $this->subtotal->formatted(),
            'total' => $this->total()->formatted(),
            'products' => ProductVariationResource::collection(
                $this->whenLoaded('products')
            ),
            'address' => new AddressResource(
                $this->whenLoaded('address')
            ),
            'shippingMethod' => new ShippingMethodResource(
                $this->whenLoaded('shippingMethod')
            ),
        ];
    }
}
