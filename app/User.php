<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username',
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function proctees()
    {
        return $this->hasMany('App\Student', 'proctor');
    }
    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'user_subject');
    }
    public function courses()
    {
        return $this->hasOne('App\Course', 'id', 'course');
    }

}
