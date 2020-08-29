<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Scoping\Scopes\CategoryScope;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductIndexResource;

class ProductController extends Controller
{
    public function index()
    {
        // Added ::with variations stock, to eager load and thus reduce the amount of queries
        // that are being sent to the database.
        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->paginate(10);

        return ProductIndexResource::collection($products);
    }

    // Route model binding the product into the show method.
    public function show(Product $product)
    {
        // Eager load variation attributes, to ensure multiple queries aren't being executed
        // when new product variations are added to the database.  
        $product->load(['variations.type', 'variations.stock', 'variations.product']);
        
        // Extends ProductIndexResource (Custom attributes to display on-screen)
        return new ProductResource(
            $product
        );
    }

    protected function scopes()
    {
        return [
            'category' => new CategoryScope()
        ];
    }
}
