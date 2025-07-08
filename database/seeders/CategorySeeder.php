<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Jasa Layanan & Servis', 'icon' => 'default.png'],
            ['name' => 'Pertambangan & Energi', 'icon' => 'default.png'],
            ['name' => 'Kuliner (F&B)', 'icon' => 'default.png'],
            ['name' => 'Perhotelan & Pariwisata', 'icon' => 'default.png'],
            ['name' => 'Logistik & Transportasi', 'icon' => 'default.png'],
            ['name' => 'Desain & Kreatif Digital', 'icon' => 'default.png'],
            ['name' => 'Konstruksi & Properti', 'icon' => 'default.png'],
            ['name' => 'Administrasi & Kantor', 'icon' => 'default.png'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['slug' => Str::slug($category['name']), 'icon' => $category['icon']]
            );
        }
    }
}
