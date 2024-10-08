<?php

namespace App;
use Laratrust\Traits\LaratrustUserTrait;

use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use LaratrustUserTrait; // add this trait to your user model

    use Notifiable;
    protected $appends=['full_name','image_path'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles()  {

        return $this->belongsToMany(Role::class);
    }
    public function getFullNameAttribute(){

        return $this->first_name . " " . $this->last_name;

    }

    public function getImagePathAttribute(){
        return asset('uploads/users/'.$this->image);
    }


}
