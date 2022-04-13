<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password','avatar','gender','phone'
//    ];

    public $guarded = [];

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

    public function getFirstNameAttribute()
    {
        $name = $this->name;
        $fullName = explode(" ", $name);
        return $firstName =  $fullName[0];
    }

    public function getLastNameAttribute()
    {
        $name = $this->name;
        $fullName = explode(" ", $name,2);
        $lastName = '';
        if(count($fullName)>1){
            $lastName = $fullName[1];
        }
        return $lastName;
    }
}
