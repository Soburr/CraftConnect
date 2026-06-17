<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;
use App\Models\Artisan;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Skill;

class UserBookingSeeder extends Seeder
{
    private array $halls = [
        'Madam Tinubu Hall',
        'Moremi',
        'Makama',
        'Fagunwa',
        'Amina',
        'Kofo',
        'Honors',
        'Mariere',
        'Eni-Njoku',
        'Shodeinde',
        'Biobaku',
        'El-Kanemi',
        'Femi Gbajabiamila Hall'
    ];

    private array $faculties = [
        'Engineering', 'Sciences', 'Arts', 'Social Sciences',
        'Law', 'Medicine', 'Education', 'Agriculture'
    ];

    private array $departments = [
        'Computer Science', 'Electrical Engineering', 'Mechanical Engineering',
        'Civil Engineering', 'Mathematics', 'Physics', 'Chemistry',
        'Economics', 'Accounting', 'Business Administration',
        'English', 'History', 'Law', 'Medicine', 'Nursing'
    ];

    private array $reviewTexts = [
        'Excellent work! Very professional and timely.',
        'Great service, would definitely book again.',
        'Very skilled and friendly. Highly recommend.',
        'Did an amazing job, exceeded my expectations.',
        'Good work but took a little longer than expected.',
        'Fantastic artisan, very detail-oriented.',
        'Solid work, fair pricing and very communicative.',
        'Really impressed with the quality of the work.',
        'Very reliable and professional throughout.',
        'Good experience overall, will book again.',
        'Outstanding service from start to finish.',
        'Skilled and efficient. Completed the job perfectly.',
    ];

    public function run(): void
    {
        $skills = Skill::with('category')->get();

        if ($skills->isEmpty()) {
            $this->command->error('No skills found. Please seed categories and skills first.');
            return;
        }

        $this->command->info('Seeding 70 ghost clients...');
        $clients = $this->seedClients(70);

        $this->command->info('Seeding 40 ghost artisans...');
        $artisans = $this->seedArtisans(40, $skills);

        $this->command->info('Creating completed bookings with reviews...');
        $this->seedBookingsAndReviews($clients, $artisans, $skills);

        $this->command->info('✅ Seeding complete!');
    }

    private function seedClients(int $count): \Illuminate\Support\Collection
    {
        $clients = collect();

        for ($i = 1; $i <= $count; $i++) {
            // Use withoutGlobalScope so we can create is_seeded users freely
            $user = User::withoutGlobalScope('real_users')->create([
                'name'                       => fake()->name(),
                'email'                      => fake()->unique()->safeEmail(),
                'password'                   => Hash::make('password'),
                'number'                     => '080' . fake()->numerify('########'),
                'role'                       => 'client',
                'status'                     => 'active',
                'is_seeded'                  => true,   // 👈 ghost flag
                'email_verified_at'          => now(),
                'verification_token'         => null,
                'verification_token_expires' => null,
            ]);

            $client = Client::create([
                'user_id'           => $user->id,
                'hall_of_residence' => fake()->randomElement($this->halls),
                'faculty'           => fake()->randomElement($this->faculties),
                'department'        => fake()->randomElement($this->departments),
                'room_number'       => strtoupper(fake()->bothify('??###')),
                'matric_no'         => strtoupper(fake()->bothify('??/##/####')),
                'avatar'            => null,
            ]);

            $clients->push(['user' => $user, 'client' => $client]);
        }

        return $clients;
    }

    private function seedArtisans(int $count, \Illuminate\Support\Collection $skills): \Illuminate\Support\Collection
    {
        $artisans = collect();

        for ($i = 1; $i <= $count; $i++) {
            $skill = $skills->random();

            $user = User::withoutGlobalScope('real_users')->create([
                'name'                       => fake()->name(),
                'email'                      => fake()->unique()->safeEmail(),
                'password'                   => Hash::make('password'),
                'number'                     => '080' . fake()->numerify('########'),
                'role'                       => 'artisan',
                'status'                     => 'active',
                'is_seeded'                  => true,   // 👈 ghost flag
                'email_verified_at'          => now(),
                'verification_token'         => null,
                'verification_token_expires' => null,
            ]);

            $artisan = Artisan::create([
                'user_id'            => $user->id,
                'hall_of_residence'  => fake()->randomElement($this->halls),
                'skill_id'           => $skill->id,
                'category_id'        => $skill->category_id,
                'years_of_experience'=> fake()->numberBetween(1, 10),
                'portfolio_url'      => fake()->optional(0.5)->url(),
                'bio'                => fake()->sentence(12),
                'faculty'            => fake()->randomElement($this->faculties),
                'department'         => fake()->randomElement($this->departments),
                'room_number'        => strtoupper(fake()->bothify('??###')),
                'matric_no'          => strtoupper(fake()->bothify('??/##/####')),
                'avatar'             => null,
                'score'              => fake()->numberBetween(0, 300),
                'tier'               => 'Bronze',
            ]);

            $artisans->push(['user' => $user, 'artisan' => $artisan]);
        }

        return $artisans;
    }

    private function seedBookingsAndReviews(
        \Illuminate\Support\Collection $clients,
        \Illuminate\Support\Collection $artisans,
        \Illuminate\Support\Collection $skills
    ): void {
        foreach ($artisans as $artisanData) {
            /** @var Artisan $artisan */
            $artisan      = $artisanData['artisan'];
            $bookingCount = fake()->numberBetween(2, 5);

            for ($b = 0; $b < $bookingCount; $b++) {
                $clientData  = $clients->random();
                $clientUser  = $clientData['user'];
                $skill       = $skills->firstWhere('id', $artisan->skill_id) ?? $skills->random();
                $bookingDate = fake()->dateTimeBetween('-6 months', '-1 week');

                $booking = Booking::create([
                    'client_id'    => $clientUser->id,
                    'artisan_id'   => $artisan->id,
                    'skill_id'     => $skill->id,
                    'booking_date' => $bookingDate,
                    'status'       => 'completed',
                    'cancelled_at' => null,
                ]);

                Review::create([
                    'booking_id' => $booking->id,
                    'client_id'  => $clientUser->id,
                    'artisan_id' => $artisan->id,
                    'skill_id'   => $skill->id,
                    'rating'     => fake()->numberBetween(3, 5),
                    'review'     => fake()->randomElement($this->reviewTexts),
                ]);
            }

            // Recalculate tier based on real average rating after reviews are inserted
            $artisan->refresh();
            $avgRating = $artisan->reviews()->avg('rating') ?? 0;
            $artisan->update(['tier' => $artisan->calculateTier($artisan->score, $avgRating)]);
        }
    }
}