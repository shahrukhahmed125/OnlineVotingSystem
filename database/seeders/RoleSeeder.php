<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']); // Ability to do anything
        Role::create(['name' => 'manager']); // can add and edit but can't delete
        Role::create(['name' => 'candidate']); // can vote and view results
        Role::create(['name' => 'voter']); // can vote and view results
        Role::create(['name' => 'user']); // default for deactivated users
    }
}
