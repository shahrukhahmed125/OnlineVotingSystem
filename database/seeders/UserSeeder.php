<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a specific admin user
        $admin = User::create([
            'user_id' => User::generateUserId(), // Add user_id generation
            'name' => 'Syed Shahrukh',
            'cnic' => '42101-1234567-8',
            'email' => 'shahrukhahmed125@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'), // Ensure password is a string
            'remember_token' => Str::random(10),
            'gender' => 'male', // These fields are not in the standard User model or factory, removing unless added
            'title' => 'Owner',
            'department' => 'Company',
            'address' => 'A 36 Block B North Nazimabad Karachi',
            'about' => 'dshfjashfjkahf',
            'city' => "Karachi",
            'postal_code' => '74600',
            'phone' => '03265419876',
            // 'two_factor_code' => null, // These are typically handled by Fortify/Jetstream if installed
            // 'two_factor_expires_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            // 'deleted_at' => null, // Handled by SoftDeletes trait
        ]);

        $admin->assignRole('admin');

        // Create a specific user user
        $user = User::create([
            'user_id' => User::generateUserId(), // Add user_id generation
            'name' => 'Syed Shahrukh',
            'cnic' => '42301-1334565-9',
            'email' => 'shahrukhahmed3821@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'), // Ensure password is a string
            'remember_token' => Str::random(10),
            'gender' => 'male', // These fields are not in the standard User model or factory, removing unless added
            'title' => 'Owner',
            'department' => 'Company',
            'address' => 'A 36 Block B North Nazimabad Karachi',
            'about' => 'dshfjashfjkahf',
            'city' => "Karachi",
            'postal_code' => '74600',
            'phone' => '03265419876',
            'na_constituency_id' => 2, // TODO: Replace 1 with a valid Assembly ID from your assemblies table
            'pa_constituency_id' => 8, // TODO: Replace 2 with a valid Assembly ID from your assemblies table
            // 'two_factor_code' => null, // These are typically handled by Fortify/Jetstream if installed
            // 'two_factor_expires_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            // 'deleted_at' => null, // Handled by SoftDeletes trait
        ]);

        $user->assignRole('voter');

        // Create a specific user user
        $candidate = User::create([
            'user_id' => User::generateUserId(), // Add user_id generation
            'name' => 'Syed Shahrukh',
            'cnic' => '42301-1354565-1',
            'email' => 'shahrukhahmed3421@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'), // Ensure password is a string
            'remember_token' => Str::random(10),
            'gender' => 'male', // These fields are not in the standard User model or factory, removing unless added
            'title' => 'Owner',
            'department' => 'Company',
            'address' => 'A 36 Block B North Nazimabad Karachi',
            'about' => 'dshfjashfjkahf',
            'city' => "Karachi",
            'postal_code' => '74600',
            'phone' => '03265419876',
            'na_constituency_id' => 2, // TODO: Replace 1 with a valid Assembly ID from your assemblies table
            'pa_constituency_id' => 8, // TODO: Replace 2 with a valid Assembly ID from your assemblies table
            // 'two_factor_code' => null, // These are typically handled by Fortify/Jetstream if installed
            // 'two_factor_expires_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            // 'deleted_at' => null, // Handled by SoftDeletes trait
        ]);

        $candidate->assignRole('candidate');

        // Create some regular voter users using the factory
        // The factory will assign 'voter' role and constituency IDs
        // User::factory()->count(20)->create()->each(function ($user) {
        //     $user->assignRole('candidate');
        // });
    }
}
