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

    public function units()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * The invoice items that belong to the item.
     */
    public function invoicesItem()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * The taxe items that belong to the item.
     */
    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }
}
