<?php

namespace Tests\Feature\Admin\Categories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CategoriesViewsTest extends TestCase
{
    public function testListView(): void
    {
        $collection = new Collection();

        $category = Category::factory()
            ->create(['name' => 'Test Category']);
        $collection->push($category);

        $pagination = [
            'total' => 1,
            'current' => 1,
            'previous' => 1,
            'next' => 1,
        ];

        $view = $this->actingAs($this->admin)
            ->view('admin.categories.main', [
                'list' => $collection,
                'pagination' => $pagination
            ]);

        $view->assertSeeText('Test Category')
            ->assertSeeText($this->admin->name);
    }

    public function testCreateView(): void
    {
        $view = $this->actingAs($this->admin)
            ->view('admin.categories.create', [
                'list' => []
            ]);

        $view->assertSeeText('Save All');
    }

    public function testUpdateView(): void
    {
        $category = Category::factory()
            ->create(['name' => 'Test Update Category']);

        $view = $this->actingAs($this->admin)
            ->view('admin.categories.update', [
                'list' => [],
                'item' => $category
            ]);

        $view->assertSeeText('Save');
    }
}
