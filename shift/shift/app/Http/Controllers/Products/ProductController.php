<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductIndexResource;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return ProductIndexResource::collection($products);
    }

    // Route model binding the product into the show method.
    public function show(Product $product)
    {
        // Extends ProductIndexResource (Custom attributes to display on-screen)
        return new ProductResource(
            $product
        );
    }
}
