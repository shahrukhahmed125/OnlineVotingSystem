<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to avoid duplicates if seeder is run multiple times
        // Candidate::query()->delete(); // Optional: if you want to clear before seeding

        // Create a number of candidates using the factory
        // Ensure AssemblySeeder and PoliticalPartySeeder have run first
        Candidate::factory()->count(50)->create(); // Create 50 candidates
    }
}
