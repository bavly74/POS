<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories=['cat1','cat2','cat3','cat4','cat5','cat6','cat7','cat8'];
        foreach ($categories as $category) {
            Category::create([
                'ar'=>['name'=>$category],
                'en'=>['name'=>$category],
            ]);
        }
    }
}
