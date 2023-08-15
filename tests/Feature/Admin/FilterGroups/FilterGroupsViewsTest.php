<?php

namespace Tests\Feature\Admin\FilterGroups;

use App\Models\FilterGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterGroupsViewsTest extends TestCase
{
    public function testListView(): void
    {
        $collection = new Collection();

        $filterGroup = FilterGroup::factory()
            ->create(['name' => 'Test Filter Group']);
        $collection->push($filterGroup);

        $pagination = [
            'total' => 1,
            'current' => 1,
            'previous' => 1,
            'next' => 1,
        ];

        $view = $this->actingAs($this->admin)
            ->view('admin.filter-groups.main', [
                'list' => $collection,
                'pagination' => $pagination
            ]);

        $view->assertSeeText('Test Filter Group')
            ->assertSeeText($this->admin->name);
    }

    public function testCreateView(): void
    {
        $view = $this->actingAs($this->admin)
            ->view('admin.filter-groups.create', [
                'list' => []
            ]);

        $view->assertSeeText('Save All');
    }

    public function testUpdateView(): void
    {
        $filterGroup = FilterGroup::factory()
            ->create(['name' => 'Test Update Filter Group']);

        $view = $this->actingAs($this->admin)
            ->view('admin.filter-groups.update', [
                'list' => [],
                'item' => $filterGroup
            ]);

        $view->assertSeeText('Save');
    }
}
