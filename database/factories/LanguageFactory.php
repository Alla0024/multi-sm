<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Language::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $langCode = $this->faker->unique()->languageCode();

        return [
            'code' => $langCode,
            'path' => $langCode,
            'status' => $this->faker->randomElement([true, false]),
            'sort_order' => $this->faker->numberBetween(0, 999)
        ];
    }
}
