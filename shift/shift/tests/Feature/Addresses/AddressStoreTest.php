<?php

namespace Tests\Feature\Addressess;

use Tests\TestCase;
use App\Models\User;
use App\Models\Country;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_fails_if_authenticated()
    {
        $this->json('POST', 'api/addresses')
            ->assertStatus(401);
    }

    public function test_it_requires_a_name()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['name']);
    }  
    
    public function test_it_requires_address_line_one()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['address_1']);
    }  

    public function test_it_requires_address_city()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['city']);
    }  

    public function test_it_requires_address_postal_code()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['postal_code']);
    }  

    public function test_it_requires_a_country()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['country_id']);
    }  

    public function test_it_requires_a_valid_country()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses', [
            'country_id' => 1
        ])
            ->assertJsonValidationErrors(['country_id']);
    }  

    public function test_it_stores_an_address()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses', $payload = [
            'name' => 'Ash Eastham',
            'address_1' => '123 Hyde Leeds Road',
            'city' => 'Leeds',
            'postal_code' => 'LS42IG',
            'country_id' => factory(Country::class)->create()->id       
        ]);

        $this->assertDatabaseHas('addresses', array_merge($payload, [
            'user_id' => $user->id,
        ]));
    }  

    public function test_it_returns_an_address_when_created()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/addresses', $payload = [
            'name' => 'Ash Eastham',
            'address_1' => '123 Hyde Leeds Road',
            'city' => 'Leeds',
            'postal_code' => 'LS42IG',
            'country_id' => factory(Country::class)->create()->id       
        ]);

        $response->assertJsonFragment([
            'id' => json_decode($response->getContent())->data->id
        ]);
    }  
}
