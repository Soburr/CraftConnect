<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
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

        foreach ($locations as $loc) {
            Location::updateOrCreate(['name' => $loc]);
        }
    }
}
