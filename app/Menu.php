<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = FALSE;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * Get the role associated with the menu
     */
    public function role(){
        return $this->belongsToMany(Role::class, 'user_access_menu');
    }

    /**
     * Get the menu list associated with the menu
     */
    public function menulist(){
        return $this->hasMany(MenuList::class);
    }
}
