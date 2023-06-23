<?php

namespace Tests\Feature\Admin\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductsRoutesTest extends TestCase
{
    public function testListUnauthenticated(): void
    {
        $response = $this->get('/admin/products');
        $response->assertStatus(302);
    }

    public function testListAuthenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/products');
        $response->assertStatus(200);
    }

    public function testCreateViewUnauthenticated(): void
    {
        $response = $this->get('/admin/products/create');
        $response->assertStatus(302);
    }

    public function testCreateViewAuthenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/products/create');
        $response->assertStatus(200);
    }

    public function testCreateUnauthenticated(): void
    {
        $data = [];

        $response = $this->post('/admin/products/create', $data);
        $response->assertStatus(302);
    }

    public function testCreateAuthenticated(): void
    {
        $data = [
            'name' => 'New Test Product',
            'description' => 'Test description',
            'price' => 21,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/products/create', $data);
        $response->assertStatus(201);
    }

    public function testUpdateViewUnauthenticated(): void
    {
        $product = Product::factory()->create();

        $response = $this->get('/admin/products/update/' . $product->id);
        $response->assertStatus(302);
    }

    public function testUpdateViewAuthenticated(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/products/update/' . $product->id);
        $response->assertStatus(200);
    }

    public function testUpdateViewWrongId(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/products/update/999');
        $response->assertStatus(404);
    }

    public function testUpdateUnauthenticated(): void
    {
        $product = Product::factory()->create();

        $response = $this->post('/admin/products/update/' . $product->id);
        $response->assertStatus(302);
    }

    public function testUpdateAuthenticated(): void
    {
        $product = Product::factory()->create(['name' => 'Original name']);
        $data = ['name' => 'Updated name'];

        $response = $this->actingAs($this->admin)->post('/admin/products/update/' . $product->id, $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated name',
        ]);
    }

    public function testUpdateWrongId(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/products/update/999', []);
        $response->assertStatus(404);
    }
}
