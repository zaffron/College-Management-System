<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GraduatedStudent extends Model
{
	protected $table = 'graduated_students';
	protected $fillable = ['name','regno', 'id', 'gender', 'email', 'contact', 'address', 'dob','course','avatar','address','proctor','semester','p_contact', 'p_email'];

	public function courses()
	{
	    return $this->hasOne('App\Course', 'id', 'course');
	}
	public function proctors()
	{
	    return $this->hasOne('App\User', 'id', 'proctor');
	}
}
