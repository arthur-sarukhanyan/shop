<?php

namespace Tests\Feature\Admin\Filters;

use App\Facades\FilterGroupFacade;
use App\Models\Filter;
use Tests\TestCase;

class FiltersRoutesTest extends TestCase
{
    public function testListUnauthenticated(): void
    {
        $response = $this->get('/admin/filters');
        $response->assertStatus(302);
    }

    public function testListAuthenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/filters');
        $response->assertStatus(200);
    }

    public function testCreateViewUnauthenticated(): void
    {
        $response = $this->get('/admin/filters/create');
        $response->assertStatus(302);
    }

    public function testCreateViewAuthenticated(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/filters/create');
        $response->assertStatus(200);
    }

    public function testCreateUnauthenticated(): void
    {
        $data = [];

        $response = $this->post('/admin/filters/create', $data);
        $response->assertStatus(302);
    }

    public function testCreateAuthenticated(): void
    {
        $filterGroup = FilterGroupFacade::create(['name' => 'Filter group']);
        $data = [
            'name' => 'Filter',
            'filter_group_id' => $filterGroup->id,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/filters/create', ['list' => [$data]]);
        $response->assertStatus(200);
    }

    public function testUpdateViewUnauthenticated(): void
    {
        $filter = Filter::factory()->create();

        $response = $this->get('/admin/filters/update/' . $filter->id);
        $response->assertStatus(302);
    }

    public function testUpdateViewAuthenticated(): void
    {
        $filter = Filter::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/filters/update/' . $filter->id);
        $response->assertStatus(200);
    }

    public function testUpdateViewWrongId(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/filters/update/999');
        $response->assertStatus(404);
    }

    public function testUpdateUnauthenticated(): void
    {
        $filter = Filter::factory()->create();

        $response = $this->post('/admin/filters/update/' . $filter->id);
        $response->assertStatus(302);
    }

    public function testUpdateAuthenticated(): void
    {
        $filter = Filter::factory()->create(['name' => 'Original name']);
        $data = ['name' => 'Updated name'];

        $response = $this->actingAs($this->admin)->post('/admin/filters/update/' . $filter->id, $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('filters', [
            'id' => $filter->id,
            'name' => 'Updated name',
        ]);
    }

    public function testUpdateWrongId(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/filters/update/999', []);
        $response->assertStatus(404);
    }
}
