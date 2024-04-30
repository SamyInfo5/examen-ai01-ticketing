<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Status
        Status::create([
            'name' => "open"
        ]);

        // Create Status
        Status::create([
            'name' => "In Progress"
        ]);

        // Create Status
        Status::create([
            'name' => "Finish"
        ]);
    }
}
