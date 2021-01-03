<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Adidas running',
            'description' => 'Chaussures de Running adidas running adizero',
            'photo' => 'https://media.alltricks.com/medium/15970695eda126e3d7300.28493766.jpg?',
            'price' => 179.95
         ]);
         DB::table('products')->insert([
             'name' => 'Nike',
             'description' => 'Chaussures de Running Nike Air Zoom Pegasus',
             'photo' => 'https://media.alltricks.com/medium/16046725ee76babc1b114.75858035.jpg',
             'price' => 89.99
         ]);
         DB::table('products')->insert([
             'name' => 'Asics',
             'description' => 'Chaussures de Running Asics Gel Nimbus 22',
             'photo' => 'https://media.alltricks.com/medium/16087835ef1ceac406025.27632357.jpg',
             'price' => 134.99
         ]);
         DB::table('products')->insert([
             'name' => 'Nike',
             'description' => 'Chaussures de Running Nike Air Zoom Pegasus 37',
             'photo' => 'https://media.alltricks.com/medium/15477155ea6bcc0d8b8d6.66984746.jpg',
             'price' => 93.99
         ]);
         DB::table('products')->insert([
             'name' => 'Hoka One One',
             'description' => 'Chaussures de Trail Hoka One One Challenger Low GTX Noir',
             'photo' => 'https://media.alltricks.com/medium/13180285ddd0b568c1502.03589712.jpg',
             'price' => 112.99
         ]);
         DB::table('products')->insert([
             'name' => 'Asics',
             'description' => 'Chaussures de Trail Asics Gel FujiTrabuco 8 Jaune',
             'photo' => 'https://media.alltricks.com/medium/16087755ef219d4d1cbb4.95101016.jpg',
             'price' => 104.99
         ]);
    }
}
