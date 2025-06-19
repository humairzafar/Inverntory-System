<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Brand;
use App\Models\DeviceModel;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 25; $i++) {
            $brand = Brand::inRandomOrder()->first();
            $deviceModel = DeviceModel::where('brand_id', $brand->id)->inRandomOrder()->first();

            Item::create([
                'name' => "Item $i",
                'amount' => rand(100, 9999) / 100,
                'brand_id' => $brand->id,
                'device_model_id' => rand(0, 1) ? $deviceModel->id : null, // Randomly assign or leave null
            ]);
        }
    }
}