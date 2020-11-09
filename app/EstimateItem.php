<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateItem extends Model
{
    protected $fillable = [
        'estimate_id',
        'name',
        'item_id',
        'description',
        'quantity',
        'company_id',
        'price',
        'discount_type',
        'discount_val',
        'tax',
        'total',
        'discount'
    ];

    protected $casts = [
        'price' => 'integer',
        'total' => 'integer',
        'discount' => 'float',
        'quantity' => 'float',
        'discount_val' => 'integer',
        'tax' => 'integer'
    ];

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }
}
