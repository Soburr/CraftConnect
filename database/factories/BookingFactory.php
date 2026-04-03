<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Artisan;
use App\Models\Skill;

class BookingFactory extends Factory
{
    protected $model = \App\Models\Booking::class;

    public function definition()
    {
        $artisan = Artisan::inRandomOrder()->first();
        $client = User::where('role', 'client')->inRandomOrder()->first();
        $skillId = $artisan->skill_id ?? Skill::inRandomOrder()->first()->id;

        $status = $this->faker->randomElement(['pending', 'completed', 'cancelled']);

        return [
            'client_id' => $client->id,
            'artisan_id' => $artisan->id,
            'skill_id' => $skillId,
            'booking_date' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'status' => $status,
            'cancelled_at' => $status === 'cancelled' ? $this->faker->dateTimeBetween('-10 days', 'now') : null,
        ];
    }
}
