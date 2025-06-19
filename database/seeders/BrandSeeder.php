<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = ['Samsung', 'Apple', 'Sony', 'LG', 'Dell'];

        foreach ($brands as $name) {
            Brand::create(['name' => $name]);
    }
}
}
