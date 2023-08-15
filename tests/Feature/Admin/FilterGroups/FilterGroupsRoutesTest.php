<?php

namespace Tests\Feature\Admin\FilterGroups;

use App\Facades\FilterGroupFacade;
use App\Models\FilterGroup;
use Tests\TestCase;

class FilterGroupsRoutesTest extends TestCase
{
    public function testListUnauthenticated(): void
    {
        $response = $this->get('/admin/filter-groups');
        $response->assertStatus(302);
    }

    public function testListAuthenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/filter-groups');
        $response->assertStatus(200);
    }

    public function testCreateViewUnauthenticated(): void
    {
        $response = $this->get('/admin/filter-groups/create');
        $response->assertStatus(302);
    }

    public function testCreateViewAuthenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/filter-groups/create');
        $response->assertStatus(200);
    }

    public function testCreateUnauthenticated(): void
    {
        $data = [];

        $response = $this->post('/admin/filter-groups/create', $data);
        $response->assertStatus(302);
    }

    public function testCreateAuthenticated(): void
    {
        $data = [
            'name' => 'Filter Group',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/filter-groups/create', ['list' => [$data]]);
        $response->assertStatus(200);
    }

    public function testUpdateViewUnauthenticated(): void
    {
        $filterGroup = FilterGroup::factory()->create();

        $response = $this->get('/admin/filter-groups/update/' . $filterGroup->id);
        $response->assertStatus(302);
    }

    public function testUpdateViewAuthenticated(): void
    {
        $filterGroup = FilterGroup::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/filter-groups/update/' . $filterGroup->id);
        $response->assertStatus(200);
    }

    public function testUpdateViewWrongId(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/filter-groups/update/999');
        $response->assertStatus(404);
    }

    public function testUpdateUnauthenticated(): void
    {
        $filterGroup = FilterGroup::factory()->create();

        $response = $this->post('/admin/filter-groups/update/' . $filterGroup->id);
        $response->assertStatus(302);
    }

    public function testUpdateAuthenticated(): void
    {
        $filterGroup = FilterGroup::factory()->create(['name' => 'Original name']);
        $data = ['name' => 'Updated name'];

        $response = $this->actingAs($this->admin)->post('/admin/filter-groups/update/' . $filterGroup->id, $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('filter_groups', [
            'id' => $filterGroup->id,
            'name' => 'Updated name',
        ]);
    }

    public function testUpdateWrongId(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/filter-groups/update/999', []);
        $response->assertStatus(404);
    }
}
