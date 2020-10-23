<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    public $timestamps = FALSE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the branch associated with the venue
     */
    public function branch(){
        return $this->belongsToMany(Branch::class, 'branch_venues');
    }
}
