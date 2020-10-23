<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassroomStudent extends Model
{
    /**
     * Get the tutor associated with the classroom
     */
    public function attendance(){
        return $this->hasMany(Attendance::class);
    }
}
