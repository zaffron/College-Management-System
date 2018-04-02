<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'std_id', 'course_id', 'semester_id','attn_date','attendance', 'updated_by'
    ];

}
