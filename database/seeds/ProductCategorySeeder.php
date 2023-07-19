<?php

use Illuminate\Database\Seeder;
use App\Product_category;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product_category::create([
            'id' => 1,
            'name' => 'インテリア'
        ]);
        Product_category::create([
            'id' => 2,
            'name' => '家電'
        ]);
        Product_category::create([
            'id' => 3,
            'name' => 'ファッション'
        ]);
        Product_category::create([
            'id' => 4,
            'name' => '美容'
        ]);
        Product_category::create([
            'id' => 5,
            'name' => '本・雑誌'
        ]);
    }
}
