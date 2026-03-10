<?php

namespace Database\Seeders;

use App\Models\TabCategories;
use App\Models\TabSubCategories;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $data = [

            'EAR RINGS' => [
                'Ear tops',
                'Ear danglers',
                'Ear hoops',
                'Ear cuffs',
                'Ear jhumkas',
                'Second piercing',
                'Third piercing',
                'Bugadi',
            ],

            'NECK PIECES' => [
                'Pendant/pendant set',
                'Neckless',
                'Chokers',
                'Bridal neck pieces',
            ],

            'WRISTLETS' => [],

            'RINGS' => [
                'Finger ring',
                'Toe ring',
            ],

            'ALL JEWELLERY' => [
                'EAR RINGS',
                'JHUMKAS',
                'NECK PIECES',
                'NOSE PINS',
                'BANGLES',
                'WRISTLETS',
                'FINGER RINGS',
                'COCKTAIL RINGS',
                'ANKLETS',
                'PAYELS',
                'TOE RINGS',
                'HAIR PINS',
            ],

            'ETTHNICOAST EXCLUSIVE' => [
                'ETHNIC',
                'ELEGANCE',
                'WEDDING WAVES',
                'GLOW & GLITTERS',
                'PARTY',
                'MINIMALISTIC',
                'INDULGENCE',
            ],

            'NEW ARRIVAL' => [],

            'MORE AT ETTHNICOAST' => [
                'About Us',
                'Why Us',
                'Chat with us',
                'Animal Welfare',
            ],
        ];

        foreach ($data as $categoryName => $subCategories) {

            $category = TabCategories::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'is_active' => true,
            ]);

            foreach ($subCategories as $subCategoryName) {
                TabSubCategories::create([
                    'category_id' => $category->id,
                    'name' => $subCategoryName,
                    'slug' => Str::slug($subCategoryName),
                    'is_active' => true,
                ]);
            }
        }
    }
}
