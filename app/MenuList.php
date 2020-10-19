<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuList extends Model
{
    public $timestamps = FALSE;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'url', 'icon', 'is_active', 'is_collapsible', 'menu_id', 'role_id'
    ];

    /**
     * Get the menu title associated with the menu list
     */
    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the roles associated with the menu list
     */
    public function role(){
        return $this->belongsToMany(Role::class, 'user_access_menu_list');
    }
}
