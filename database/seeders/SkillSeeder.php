<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'Fashion' => ['Tailoring', 'Makeup', 'Hair Styling', 'Fashion Design', 'Wears', 'Bag Making', 'Nail Tech', 'Lash Tech'],
            'Tech' => ['Web Development', 'Graphic Design', 'UI/UX Design'],
            'Cleaning' => ['Laundry', 'Hostel Cleaning'],
            'Repairs' => ['Phone Repair', 'Plumbing', 'Electrical Fix', 'Carpentry', 'Laptop Fix', 'Shoe Repair',],
            'Events' => ['Caterer', 'MC', 'Event Planner'],
            'Crafts' => ['Bead Making', 'Painting', 'Printing', 'Shoe Making'],
            'Logistics' => ['Delivery Services'],
            'Lifestyle' => ['DJ', 'Hypeman', 'Photographer', 'Videographer']
        ];

        foreach($skills as $categoryName => $skillNames) {
            $category = Category::where('name', $categoryName)->first();

            if($category) {
               foreach($skillNames as $skillName) {
                 Skill::updateOrCreate(
                    ['name' => $skillName, 'category_id' => $category->id],
                    ['category_id' => $category->id]
                 );
               }
            }
        }
    }
}
