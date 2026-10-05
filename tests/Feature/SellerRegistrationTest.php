<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_visitor_can_register_as_a_seller(): void
    {
        $response = $this->post(route('seller.register.store'), [
            'name' => 'Ma Boutique',
            'city' => 'Casablanca',
            'email' => 'vendeur@example.com',
            'password' => 'MotDePasse123!',
            'password_confirmation' => 'MotDePasse123!',
        ]);

        $seller = User::where('email', 'vendeur@example.com')->first();

        $response->assertRedirect(route('seller.dashboard'));
        $this->assertAuthenticatedAs($seller);
        $this->assertTrue($seller->isSeller());
    }

    public function test_a_guest_cannot_open_the_seller_dashboard(): void
    {
        $this->get(route('seller.dashboard'))
            ->assertRedirect(route('seller.login'));
    }

    public function test_a_seller_can_publish_a_product_that_appears_on_the_homepage(): void
    {
        Storage::fake('public');
        $seller = User::factory()->create(['role' => 'seller']);

        $this->actingAs($seller)
            ->post(route('seller.products.store'), [
                'name' => 'Veste publiée',
                'description' => 'Une veste test.',
                'price' => '89.90',
                'stock' => 4,
                'image' => UploadedFile::fake()->image('veste.jpg'),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('products', [
            'seller_id' => $seller->id,
            'name' => 'Veste publiée',
            'price' => '89.90',
        ]);

        $this->get('/')->assertSee('Veste publiée');
    }
}
