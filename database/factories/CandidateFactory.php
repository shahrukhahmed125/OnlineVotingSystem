<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Assembly;
use App\Models\PoliticalParty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $assemblyIds = Assembly::pluck('id')->toArray();
        $politicalPartyIds = PoliticalParty::pluck('id')->toArray();

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'CNIC' => fake()->unique()->numerify('#####-#######-#'), // Example CNIC format
            'constituency_id' => fake()->randomElement($assemblyIds ?: [null]), // Assign a random assembly
            'political_party_id' => fake()->randomElement($politicalPartyIds ?: [null]), // Assign a random political party
        ];
    }
}
