<?php

use Illuminate\Database\Seeder;

class Product_categoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('product_categories')->insert([
            'name' => 'インテリア'
        ]);
        DB::table('product_categories')->insert([
            'name' => '家電'
        ]);
        DB::table('product_categories')->insert([
            'name' => 'ファッション'
        ]);
        DB::table('product_categories')->insert([
            'name' => '美容'
        ]);
        DB::table('product_categories')->insert([
            'name' => '本・雑誌'
        ]);

    }
}
