<?php

use Illuminate\Database\Seeder;

class Product_subcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('product_subcategories')->insert([
            'product_category_id' => 1,
            'name' => '収納家具'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 1,
            'name' => '寝具'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 1,
            'name' => 'ソファ'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 1,
            'name' => 'ベッド'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 1,
            'name' => '照明'
        ]);


        //
        DB::table('product_subcategories')->insert([
            'product_category_id' => 2,
            'name' => 'テレビ'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 2,
            'name' => '掃除機'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 2,
            'name' => 'エアコン'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 2,
            'name' => '冷蔵庫'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 2,
            'name' => 'レンジ'
        ]);


        //
        DB::table('product_subcategories')->insert([
            'product_category_id' => 3,
            'name' => 'トップス'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 3,
            'name' => 'ボトム'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 3,
            'name' => 'ワンピース'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 3,
            'name' => 'ファッション小物'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 3,
            'name' => 'ドレス'
        ]);


        //
        DB::table('product_subcategories')->insert([
            'product_category_id' => 4,
            'name' => 'ネイル'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 4,
            'name' => 'アロマ'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 4,
            'name' => 'スキンケア'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 4,
            'name' => '香水'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 4,
            'name' => 'メイク'
        ]);


        //
        DB::table('product_subcategories')->insert([
            'product_category_id' => 5,
            'name' => '旅行'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 5,
            'name' => 'ホビー'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 5,
            'name' => '写真集'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 5,
            'name' => '小説'
        ]);
        DB::table('product_subcategories')->insert([
            'product_category_id' => 5,
            'name' => 'ライフスタイル'
        ]);



    }
}
