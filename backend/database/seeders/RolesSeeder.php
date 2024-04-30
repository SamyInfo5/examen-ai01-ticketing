<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Roles
        Roles::create([
            'name' => 'admin',
        ]);

        // Create test Roles
        Roles::create([
            'name' => 'test',
        ]);

        // Create support user
        Roles::create([
            'name' => 'support',
        ]);
    }
}
