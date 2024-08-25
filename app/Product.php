<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Product extends Model
{
    use Translatable;

    protected $guarded =[];
    public $translatedAttributes = ['name','description'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
