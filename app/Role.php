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
    public function users(){
        return $this->hasMany('App\User');
    }

    /**
     * Get the menu title associated with the roles
     */
    public function menus(){
        return $this->belongsToMany(Menu::class, 'menu_role');
    }

    /**
     * Get the menu list associated with the roles
     */
    public function menulists(){
        return $this->belongsToMany(MenuList::class, 'menu_list_role');
    }
}
