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
        $admin = User::create([
            'name' => 'Syed Shahrukh',
            'cnic' => '42101-1234567-8',
            'email' => 'shahrukhahmed125@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt(123456789),
            'remember_token' => Str::random(10),
            'gender' => 'male',
            'title' => 'Owner',
            'department' => 'Company',
            'address' => 'A 36 Block B North Nazimabad Karachi',
            'about' => 'dshfjashfjkahf',
            'city' => "Karachi",
            'postal_code' => '74600',
            'phone' => '03265419876',
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);

        $admin->assignRole('admin');

    }
}
