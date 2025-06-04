<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CallLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'duration' => fake()->numberBetween('30','1000'),
            'timestamps' => fake()->dateTimeBetween('03/01/2025','04/04/2025'),
            'status' => fake()->randomElement(['completed','missed']),
            'contact_id' => Contact::factory()
        ];
    }
}
