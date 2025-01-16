<?php
/*
 * author Arya Permana - Kirin
 * created on 17-01-2025-00h-04m
 * github: https://github.com/KirinZero0
 * copyright 2025
*/


namespace Database\Seeders;

use App\Models\Patient;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Obat Bebas'],
            ['name' => 'Obat Bebas Terbatas'],
            ['name' => 'Obat Keras'],
            ['name' => 'Obat Generic'],
            ['name' => 'Obat Patent'],
            ['name' => 'Lainnya'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
