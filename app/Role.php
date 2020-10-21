<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = FALSE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role'
    ];

    /**
     * Get the user associated with the roles
     */
    public function user(){
        return $this->hasMany('App\User');
    }

    /**
     * Get the branch associated with the roles
     */
    public function branch(){
        return $this->belongsToMany(Branch::class, 'user_access_branch');
    }

    /**
     * Get the menu title associated with the roles
     */
    public function menu(){
        return $this->belongsToMany(Menu::class, 'user_access_menu');
    }

    /**
     * Get the menu list associated with the roles
     */
    public function menulist(){
        return $this->belongsToMany(MenuList::class, 'user_access_menu_list');
    }
}
