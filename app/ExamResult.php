<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mark', 'total_mark', 'status', 'remarks', 'grade' 
    ];
}
