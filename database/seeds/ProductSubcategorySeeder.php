<?php

use Illuminate\Database\Seeder;
use App\Product_subcategory;

class ProductSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product_subcategory::create([
            'id' => 1,
            'product_category_id' => 1,
            'name' => '収納家具'
        ]);
        Product_subcategory::create([
            'id' => 2,
            'product_category_id' => 1,
            'name' => '寝具'
        ]);
        Product_subcategory::create([
            'id' => 3,
            'product_category_id' => 1,
            'name' => 'ソファ'
        ]);
        Product_subcategory::create([
            'id' => 4,
            'product_category_id' => 1,
            'name' => 'ベッド'
        ]);
        Product_subcategory::create([
            'id' => 5,
            'product_category_id' => 1,
            'name' => '照明'
        ]);
        Product_subcategory::create([
            'id' => 6,
            'product_category_id' => 2,
            'name' => 'テレビ'
        ]);
        Product_subcategory::create([
            'id' => 7,
            'product_category_id' => 2,
            'name' => '掃除機'
        ]);
        Product_subcategory::create([
            'id' => 8,
            'product_category_id' => 2,
            'name' => 'エアコン'
        ]);
        Product_subcategory::create([
            'id' => 9,
            'product_category_id' => 2,
            'name' => '冷蔵庫'
        ]);
        Product_subcategory::create([
            'id' => 10,
            'product_category_id' => 2,
            'name' => 'レンジ'
        ]);
        Product_subcategory::create([
            'id' => 11,
            'product_category_id' => 3,
            'name' => 'トップス'
        ]);
        Product_subcategory::create([
            'id' => 12,
            'product_category_id' => 3,
            'name' => 'ボトム'
        ]);
        Product_subcategory::create([
            'id' => 13,
            'product_category_id' => 3,
            'name' => 'ワンピース'
        ]);
        Product_subcategory::create([
            'id' => 14,
            'product_category_id' => 3,
            'name' => 'ファッション小物'
        ]);
        Product_subcategory::create([
            'id' => 15,
            'product_category_id' => 3,
            'name' => 'ドレス'
        ]);
        Product_subcategory::create([
            'id' => 16,
            'product_category_id' => 4,
            'name' => 'ネイル'
        ]);
        Product_subcategory::create([
            'id' => 17,
            'product_category_id' => 4,
            'name' => 'アロマ'
        ]);
        Product_subcategory::create([
            'id' => 18,
            'product_category_id' => 4,
            'name' => 'スキンケア'
        ]);
        Product_subcategory::create([
            'id' => 19,
            'product_category_id' => 4,
            'name' => '香水'
        ]);
        Product_subcategory::create([
            'id' => 20,
            'product_category_id' => 4,
            'name' => 'メイク'
        ]);
        Product_subcategory::create([
            'id' => 21,
            'product_category_id' => 5,
            'name' => '旅行'
        ]);
        Product_subcategory::create([
            'id' => 22,
            'product_category_id' => 5,
            'name' => 'ホビー'
        ]);
        Product_subcategory::create([
            'id' => 23,
            'product_category_id' => 5,
            'name' => '写真集'
        ]);
        Product_subcategory::create([
            'id' => 24,
            'product_category_id' => 5,
            'name' => '小説'
        ]);
        Product_subcategory::create([
            'id' => 25,
            'product_category_id' => 5,
            'name' => 'ライフスタイル'
        ]);
    }
}
