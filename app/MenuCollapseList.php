<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuCollapseList extends Model
{
    public $timestamps = FALSE;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'url', 'icon', 'is_active'
    ];

    /**
     * Get the role associated with the menu
     */
    public function role(){
        return $this->belongsToMany(Role::class, 'user_access_menu_collapse_list');
    }
}
