<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['courses_id', 'subjects_id', 'name'];

    public function subjects()
    {
        return $this->belongsToMany('App\Subject' , 'course_subject');
    }
    public function students()
    {
    	return $this->belongsToMany('App\Student', 'course_student', 'course_id', 'student_id');
    }

}
