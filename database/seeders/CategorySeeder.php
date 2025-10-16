<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fashion', 'description' => 'Tailoring, makeup, hair styling and more'],
            ['name' => 'Tech', 'description' => 'Web Development, graphics design, more'],
            ['name' => 'Cleaning', 'description' => 'Laundry, room cleaning'],
            ['name' => 'Repairs', 'description' => 'plumbing, electrical, carpentry and related jobs'],
            ['name' => 'Events', 'description' => 'Catering, and more'],
            ['name' => 'Logistics', 'description' => 'Delivery services'],
            ['name' => 'Crafts', 'description' => 'Bead making, painting, printing, and more'],
            ['name' => 'Lifestyle', 'description' => 'DJ, photography, videography, and more'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
