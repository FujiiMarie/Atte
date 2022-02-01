<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['user_id', 'work_day', 'start_time', 'end_time','total_work_time'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
