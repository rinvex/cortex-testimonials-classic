<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Database\Factories;

use Cortex\Testimonials\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attestant_id' => $this->faker->randomNumber(),
            'attestant_type' => $this->faker->randomElement(['App\Models\Member', 'App\Models\Manager', 'App\Models\Admin']),
            'subject_id' => $this->faker->randomNumber(),
            'subject_type' => $this->faker->randomElement(['App\Models\Company', 'App\Models\Product', 'App\Models\User']),
            'is_approved' => $this->faker->boolean,
            'body' => $this->faker->paragraph,
        ];
    }
}
