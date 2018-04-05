<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    public function courses()
    {
    	return $this->hasOne('App\Course', 'id', 'course');
    }
    public function subjects()
    {
    	return $this->hasOne('App\Subject', 'id', 'subject');
    }
}
