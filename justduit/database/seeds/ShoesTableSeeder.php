<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shoes')->insert([
            [
                'name' => 'mariya takeuchi',
                'price' => 23000,
                'description' => 'Plastic Love',
                'image' => 'images/7NrnJPzIOprl16jEK1q71bJtUR2Gj0zXFBBXAUwO.png'
            ],

            [
                'name' => 'Mariya takeuchi Album',
                'price' => 100000,
                'description' => 'Plastic Love Renew',
                'image' => 'images/4r8FhX3LwTYmRBOCU9lcMKCq17c4e8Ow42wkhcpb.jpeg'
            ],

            [
                'name' => 'Bebek',
                'price' => 300,
                'description' => 'This is bebek',
                'image' => 'images/M0YLy8F8ZPra1pX41AMEBQRboEyBLSmswAw9aZbm.webp'
            ],
        ]);
    }
}
