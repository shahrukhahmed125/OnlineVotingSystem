<?php

namespace Database\Factories;

use App\Models\Election;
use App\Models\Assembly;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Election>
 */
class ElectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Election::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $assemblyIds = Assembly::pluck('id')->toArray();
        
        $startDate = Carbon::instance(fake()->dateTimeBetween('-1 month', '+1 month'));
        $endDate = Carbon::instance(fake()->dateTimeBetween($startDate, $startDate->copy()->addWeeks(2)));

        return [
            'election_id' => Election::generateElectionId(),
            'title' => fake()->sentence(3) . ' Election',
            'description' => fake()->paragraph(),
            'start_time' => $startDate,
            'end_time' => $endDate,
            'assembly_id' => fake()->randomElement($assemblyIds ?: [null]), // Handle empty $assemblyIds
            'is_active' => fake()->boolean(75), // 75% chance of being active
        ];
    }
}
