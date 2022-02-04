<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    protected $fillable = ['user_id', 'work_day', 'start_rest', 'end_rest','rest-time'];

    public function attendance(){
        return $this->belongsTo('App\Models\Attendance');
    }
}