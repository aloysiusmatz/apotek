<?php

namespace Database\Factories;

use App\Models\m_items;
use Illuminate\Database\Eloquent\Factories\Factory;

class m_itemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = m_items::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'desc' => $this->faker->paragraph,
            'selling_price' => $this->faker->numberBetween(1000,10000),
            'lock' => $this->faker->numberBetween(0,1),
        ];
    }
}
