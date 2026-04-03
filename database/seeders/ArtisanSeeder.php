<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Artisan;
use App\Models\Skill;

class ArtisanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $password = Hash::make('password123');

        $allowedSkills = [
            'DJ',
            'Hypeman',
            'Laundry',
            'MC',
            'Hostel Cleaning',
            'Plumbing'
        ];

        $skills = Skill::whereIn('name', $allowedSkills)->get();

        foreach (range(1, 70) as $i) {

            $user = User::create([
                'name' => $faker->name,
                'email' => "artisan{$i}@craftconnect.test",
                'password' => $password,
                'role' => 'artisan',
                'email_verified_at' => now()
            ]);

            $skill = $skills->random();

            Artisan::create([
                'user_id' => $user->id,
                'skill_id' => $skill->id,
                'category_id' => $skill->category_id,

                'hall_of_residence' => $faker->randomElement([
                    'Jaja Hall',
                    'Moremi Hall',
                    'Fagunwa Hall',
                    'Biobaku Hall',
                    'Eni Njoku Hall',
                ]),

                'faculty' => $faker->randomElement([
                    'Engineering',
                    'Science',
                    'Arts',
                    'Education',
                    'Social Sciences',
                ]),

                'department' => $faker->randomElement([
                    'Computer Science',
                    'Physics',
                    'Mass Communication',
                    'Mechanical Engineering',
                ]),

                'room_number' => $faker->numberBetween(100, 499),
                'matric_no' => 'UNILAG/' . $faker->year . '/' . $faker->unique()->numberBetween(1000, 9999),

                'years_of_experience' => $faker->numberBetween(1, 8),

                'portfolio_url' => $faker->optional()->url,
                'bio' => $faker->sentence(12),

                'avatar' => null,
                'score' => $faker->numberBetween(50, 100),
                'tier' => $faker->randomElement(['bronze', 'silver', 'gold']),
            ]);
        }
    }
}
