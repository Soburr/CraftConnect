<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $password = Hash::make('password123');

        foreach (range(1, 40) as $i) {
            User::create([
                'name' => $faker->name,
                'email' => "client{$i}@craftconnect.test",
                'password' => $password,
                'role' => 'client',
                'email_verified_at' => now()
            ]);
        }
    }
}
