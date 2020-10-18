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
        'title', 'url', 'icon', 'is_active', 'is_collapsible'
    ];
}
