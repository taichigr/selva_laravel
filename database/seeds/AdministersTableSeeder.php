<?php

use Illuminate\Database\Seeder;

class AdministersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $administer = new \App\Administer([
            'name' => 'adminuser',
            'login_id' => 'adminuser',
            'password' => 'passpass',
        ]);
        $administer->save();
    }
}
