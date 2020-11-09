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
        'name', 'address', 'city', 'logo', 'unique_hash'
    ];

    /**
     * Get the user associated with the branch
     */
    public function users(){
        return $this->belongsToMany(User::class, 'branch_user');
    }

    /**
     * Get the venue associated with the branch
     */
    public function venues(){
        return $this->belongsToMany(Venue::class, 'branch_venues');
    }

    /**
     * Get the student associated with the branch
     */
    public function student(){
        return $this->hasMany(Student::class);
    }

    /**
     * Get the tutor associated with the branch
     */
    public function tutor(){
        return $this->hasMany(Tutor::class);
    }
}
