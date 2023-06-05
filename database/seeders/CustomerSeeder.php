<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new Customer();
        $user->name = 'customer';
        $user->email = 'customer@gmail.com';
        $user->password = Hash::make('password');
        $user->save();
    }
}
