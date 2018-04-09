<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GraduatedStudent extends Model
{
	protected $table = 'graduated_students';
	protected $fillable = ['name', 'id', 'gender', 'email', 'contact', 'address', 'dob','course','avatar','address','proctor','semester'];
}
