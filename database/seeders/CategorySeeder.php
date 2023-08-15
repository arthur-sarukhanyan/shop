<?php

namespace Database\Seeders;

use App\Facades\CategoryFacade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryFacade::create(['name' => 'base']);
    }
}
