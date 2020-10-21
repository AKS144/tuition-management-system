<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $timestamps = FALSE;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'city'
    ];

    /**
     * Get the roles associated with the branch
     */
    public function role(){
        return $this->belongsToMany(Role::class, 'user_access_branch');
    }

    /**
     * Get the student associated with the branch
     */
    public function student(){
        return $this->hasMany(Student::class);
    }
}
