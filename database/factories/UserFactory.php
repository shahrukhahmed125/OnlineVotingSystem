<?php

namespace Database\Factories;

use App\Models\Assembly;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch available assembly IDs once
        $naAssemblyIds = Assembly::where('type', 'NA')->pluck('id')->toArray();
        $paAssemblyIds = Assembly::where('type', 'PA')->pluck('id')->toArray();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'CNIC' => fake()->unique()->numerify('#####-#######-#'), // Example CNIC format
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'na_constituency_id' => fake()->optional()->randomElement($naAssemblyIds ?: [null]), // Handle empty $naAssemblyIds
            'pa_constituency_id' => fake()->optional()->randomElement($paAssemblyIds ?: [null]), // Handle empty $paAssemblyIds
            'user_id' => User::generateUserId(), // Assuming User model has this method
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Assign a default role, e.g., 'voter'
            // Ensure the role exists, or create it if necessary in your RoleSeeder
            $voterRole = Role::where('name', 'voter')->first();
            if ($voterRole) {
                $user->assignRole($voterRole);
            }
        });
    }
}
