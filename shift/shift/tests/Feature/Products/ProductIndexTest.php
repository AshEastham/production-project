<?php

namespace Tests\Feature\Products;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductIndexTest extends TestCase
{
    public function test_it_shows_a_collection_of_products()
    {
        $product = factory(Product::class)->create();

        $this->json('GET', 'api/products')
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }

    public function test_it_has_paginated_data()
    {
        $this->json('GET', 'api/products')
            ->assertJsonStructure([
                'data',
                'links',
                'meta'
            ]);
    }
}
