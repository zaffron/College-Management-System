<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function courses()
    {
        return $this->hasOne('App\Course', 'id');
    }
    public function proctors()
    {
        return $this->hasOne('App\User', 'id');
    }
}
