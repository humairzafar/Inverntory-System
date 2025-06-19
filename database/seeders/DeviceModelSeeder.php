<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeviceModel;
use App\Models\Brand;
class DeviceModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            ['Galaxy S23', 'Samsung'],
            ['Galaxy A54', 'Samsung'],
            ['iPhone 15', 'Apple'],
            ['iPhone SE', 'Apple'],
            ['Bravia X90', 'Sony'],
            ['Xperia 5', 'Sony'],
            ['OLED C2', 'LG'],
            ['Gram 17', 'LG'],
            ['XPS 15', 'Dell'],
            ['Inspiron 14', 'Dell']
        ];

        foreach ($models as [$modelName, $brandName]) {
            $brand = Brand::where('name', $brandName)->first();
            if ($brand) {
                DeviceModel::create([
                    'name' => $modelName,
                    'brand_id' => $brand->id,
                ]);
            }
        }
    }
}