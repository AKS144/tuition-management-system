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
     * Get the menu list titlw associated with the collapsible menu
     */
    public function menuList(){
        return $this->belongsTo(MenuList::class);
    }
}
