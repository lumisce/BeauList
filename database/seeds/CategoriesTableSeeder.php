<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
        	['id' => 1, 'name' => 'Skincare'],
        	['id' => 2, 'name' => 'Cleansing'],
        	['id' => 3, 'name' => 'Base'],
        	['id' => 4, 'name' => 'Eyes|Lips|Cheek'],
        	['id' => 5, 'name' => 'Masks'],
        	['id' => 6, 'name' => 'Suncare'],
        	['id' => 7, 'name' => 'Special Care'],
        	['id' => 8, 'name' => 'Body|Hand|Foot'],
        	['id' => 9, 'name' => 'Hair Care'],
        	['id' => 10, 'name' => 'Nail Care'],
        	['id' => 11, 'name' => 'Contact Lenses'],
        	['id' => 12, 'name' => 'Perfumes'],
        	['id' => 13, 'name' => 'Tools|Others'],

        	['id' => 14, 'parent' => 1, 'name' => 'Toner'],
        	['id' => 15, 'parent' => 1, 'name' => 'Lotion'],
        	['id' => 16, 'parent' => 1, 'name' => 'Essence'],
        	['id' => 17, 'parent' => 1, 'name' => 'Cream'],
        	['id' => 18, 'parent' => 2, 'name' => 'Cleansing Water'],
        	['id' => 19, 'parent' => 2, 'name' => 'Cleansing Wipes'],
        	['id' => 20, 'parent' => 3, 'name' => 'Primer'],
        	['id' => 21, 'parent' => 3, 'name' => 'Foundation'],
        	['id' => 22, 'parent' => 3, 'name' => 'Concealer'],
        	['id' => 23, 'parent' => 3, 'name' => 'Powder'],
        	['id' => 24, 'parent' => 4, 'name' => 'Blush'],
        	['id' => 25, 'parent' => 4, 'name' => 'Contour'],
        	['id' => 26, 'parent' => 4, 'name' => 'Highlighter'],
        	['id' => 27, 'parent' => 4, 'name' => 'Eyebrow'],
        	['id' => 28, 'parent' => 4, 'name' => 'Eyeshadow'],
        	['id' => 29, 'parent' => 4, 'name' => 'Eyeliner'],
        	['id' => 30, 'parent' => 4, 'name' => 'Mascara'],
        	['id' => 31, 'parent' => 4, 'name' => 'Lipstick'],
        	['id' => 32, 'parent' => 4, 'name' => 'Lip Tint'],
        	['id' => 33, 'parent' => 5, 'name' => 'Sheet Mask'],
        	['id' => 34, 'parent' => 6, 'name' => 'Sunblock'],
        	['id' => 35, 'parent' => 7, 'name' => 'Wrinkle Care'],
        	['id' => 36, 'parent' => 7, 'name' => 'Acne Care'],
        	['id' => 37, 'parent' => 8, 'name' => 'Body Wash'],
        	['id' => 38, 'parent' => 9, 'name' => 'Hair Color'],
        	['id' => 39, 'parent' => 10, 'name' => 'Nail Polish'],
        	['id' => 40, 'parent' => 11, 'name' => 'Color Lenses'],
        	['id' => 41, 'parent' => 12, 'name' => 'Candles'],
        	['id' => 42, 'parent' => 13, 'name' => 'Brush'],
        	['id' => 43, 'parent' => 13, 'name' => 'Lashes'],
        ];

        foreach ($items as $item) {
        	Category::updateOrCreate(['id' => $item['id']], $item);
        }
    }
}
