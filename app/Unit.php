<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Unit extends Model
{
    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
