<?php

namespace Database\Factories;

use App\Models\FilterGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filter>
 */
class FilterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name . ' Filter',
            'filter_group_id' => (FilterGroup::factory()->create())->id,
        ];
    }
}
