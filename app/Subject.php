<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_subject');
    }
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_subject');
    }
}
