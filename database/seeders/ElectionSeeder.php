<?php

namespace Database\Seeders;

use App\Models\Election;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to avoid duplicates if seeder is run multiple times
        // Election::query()->delete(); // Optional: if you want to clear before seeding

        // Create a number of elections using the factory
        // Ensure AssemblySeeder has run first so assembly_id can be assigned
        Election::factory()->count(15)->create(); // Create 15 elections
    }
}
