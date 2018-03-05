<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function courses()
    {
        $this->belongsToMany('App\Course', 'course_subject');
    }
}
