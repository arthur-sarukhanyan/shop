<?php

namespace Tests\Feature\Admin\Filters;

use App\Models\Filter;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class FiltersViewsTest extends TestCase
{
    public function testListView(): void
    {
        $collection = new Collection();

        $filter = Filter::factory()
            ->create(['name' => 'Test Filter']);
        $collection->push($filter);

        $pagination = [
            'total' => 1,
            'current' => 1,
            'previous' => 1,
            'next' => 1,
        ];

        $view = $this->actingAs($this->admin)
            ->view('admin.filters.main', [
                'list' => $collection,
                'pagination' => $pagination
            ]);

        $view->assertSeeText('Test Filter')
            ->assertSeeText($this->admin->name);
    }

    public function testCreateView(): void
    {
        $view = $this->actingAs($this->admin)
            ->view('admin.filters.create', [
                'list' => []
            ]);

        $view->assertSeeText('Save All');
    }

    public function testUpdateView(): void
    {
        $filter = Filter::factory()
            ->create(['name' => 'Test Update Filter']);

        $view = $this->actingAs($this->admin)
            ->view('admin.filters.update', [
                'list' => [],
                'item' => $filter
            ]);

        $view->assertSeeText('Save');
    }
}
