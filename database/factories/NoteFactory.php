<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();

        return [
            'user_id' => $this->faker->randomElement($users),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'deleted_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
