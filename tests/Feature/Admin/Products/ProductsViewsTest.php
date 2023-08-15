<?php

namespace Tests\Feature\Admin\Products;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ProductsViewsTest extends TestCase
{
    public function testListView(): void
    {
        $collection = new Collection();

        $product = Product::factory()
            ->create(['name' => 'Test Product']);
        $collection->push($product);

        $pagination = [
            'total' => 1,
            'current' => 1,
            'previous' => 1,
            'next' => 1,
        ];

        $view = $this->actingAs($this->admin)
            ->view('admin.products.main', [
                'list' => $collection,
                'pagination' => $pagination
            ]);

        $view->assertSeeText('Test Product')
            ->assertSeeText($this->admin->name);
    }

    public function testCreateView(): void
    {
        $view = $this->actingAs($this->admin)
            ->view('admin.products.create', [
                'listCategories' => []
            ]);

        $view->assertSeeText('Save All');
    }

    public function testUpdateView(): void
    {
        $product = Product::factory()
            ->create(['name' => 'Test Update Product']);

        $view = $this->actingAs($this->admin)
            ->view('admin.products.update', [
                'listCategories' => [],
                'listFilterGroups' => [],
                'item' => $product
            ]);

        $view->assertSeeText('Save');
    }
}
