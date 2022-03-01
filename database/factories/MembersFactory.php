<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        return [
            //
            'family_tree_id' => $this->faker->numberBetween(1,5),
            'name' => $this->faker->name(),
            'dob' => $this->faker->date(),
            'dod' => $this->faker->date(),
            'gender' => $gender,
            'father_id' => User::all()->random()->id,
            'mother_id' => User::all()->random()->id,
            'couple_id'=>User::all()->random()->id,
            'img' => $this->faker->image('public/storage/img', null, false),
        ];
    }
}
