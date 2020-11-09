<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Unit;

class Item extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'price',
        'branch_id',
        'description',
        'unit_id',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
