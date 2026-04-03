<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'booking_id' => null,
            'client_id' => null,
            'artisan_id' => null,
            'skill_id' => null,
            'rating' => $this->faker->numberBetween(3, 5),
            'review' => $this->faker->sentence(12),
        ];
    }
}
