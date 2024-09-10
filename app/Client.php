<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded=[];

    protected $casts=[
        'phone'=>'array',
        'address'=>'array'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
