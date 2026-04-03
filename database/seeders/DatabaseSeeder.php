<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Skill;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                // 1️⃣ Seed 120 bookings
                Booking::factory()
                ->count(120)
                ->create();

            // 2️⃣ Get all completed bookings
            $completedBookings = Booking::where('status', 'completed')->get();

            // 3️⃣ Shuffle and take up to 80 bookings for reviews
            $bookingsForReview = $completedBookings->shuffle()->take(min(80, $completedBookings->count()));

            // 4️⃣ Create reviews for these bookings
            foreach ($bookingsForReview as $booking) {
                Review::factory()->create([
                    'booking_id' => $booking->id,
                    'client_id'  => $booking->client_id,
                    'artisan_id' => $booking->artisan_id,
                    'skill_id'   => $booking->skill_id,
                ]);
            }
    //    $this->call([
    //       CategorySeeder::class,
    //       SkillSeeder::class,
    //       ArtisanSeeder::class,
    //       ClientSeeder::class
    //    ]);
    }
}
