<?php

namespace Tests\Feature\Admin\Categories;

use App\Facades\CategoryFacade;
use App\Models\Category;
use Tests\TestCase;

class CategoriesRoutesTest extends TestCase
{
    public function testListUnauthenticated(): void
    {
        $response = $this->get('/admin/categories');
        $response->assertStatus(302);
    }

    public function testListAuthenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/categories');
        $response->assertStatus(200);
    }

    public function testCreateViewUnauthenticated(): void
    {
        $response = $this->get('/admin/categories/create');
        $response->assertStatus(302);
    }

    public function testCreateViewAuthenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/categories/create');
        $response->assertStatus(200);
    }

    public function testCreateUnauthenticated(): void
    {
        $data = [];

        $response = $this->post('/admin/categories/create', $data);
        $response->assertStatus(302);
    }

    public function testCreateAuthenticated(): void
    {
        $data = [
            'name' => 'New Test Category',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/categories/create', ['list' => [$data]]);
        $response->assertStatus(200);
    }

    public function testCreatedPath(): void
    {
        $category = CategoryFacade::findByName('base');
        $data = [
            'name' => 'Test Category with path',
            'parent_id' => $category->id,
        ];

        $this->actingAs($this->admin)->post('/admin/categories/create', ['list' => [$data]]);
        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category with path',
            'path' => '|' . $category->id . '|',
        ]);
    }

    public function testUpdateViewUnauthenticated(): void
    {
        $category = Category::factory()->create();

        $response = $this->get('/admin/categories/update/' . $category->id);
        $response->assertStatus(302);
    }

    public function testUpdateViewAuthenticated(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/categories/update/' . $category->id);
        $response->assertStatus(200);
    }

    public function testUpdateViewWrongId(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/categories/update/999');
        $response->assertStatus(404);
    }

    public function testUpdateUnauthenticated(): void
    {
        $category = Category::factory()->create();

        $response = $this->post('/admin/categories/update/' . $category->id);
        $response->assertStatus(302);
    }

    public function testUpdateAuthenticated(): void
    {
        $category = Category::factory()->create(['name' => 'Original name']);
        $data = ['name' => 'Updated name'];

        $response = $this->actingAs($this->admin)->post('/admin/categories/update/' . $category->id, $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated name',
        ]);
    }

    public function testUpdateWrongId(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/categories/update/999', []);
        $response->assertStatus(404);
    }
}
