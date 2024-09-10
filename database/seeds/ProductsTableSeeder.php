<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['pro 1','pro 2','pro 3','pro 4','pro 5','pro 6'];
        foreach ($products as $product) {
            Product::create([
               'category_id' => 1,
               'ar'=>['name'=>$product , 'description'=>$product.'description'],
               'en'=>['name'=>$product , 'description'=>$product.'description'],
                'purchase_price'=>150,
                'sale_price'=>180,
                'stock'=>100,


            ]);
        }
    }
}
