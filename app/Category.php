<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use Translatable;

    protected $guarded =[];
    public $translatedAttributes = ['name'];

    public function products(){
        return $this->hasMany(Product::class);
    }

}
