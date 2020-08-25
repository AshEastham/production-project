<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Merge custom array with ProductIndexResource, 
        // to display custom properties only on single items.  Not on the /products endpoint.
        return array_merge(parent::toArray($request), [
            'variations' => []
        ]);
    }
}
