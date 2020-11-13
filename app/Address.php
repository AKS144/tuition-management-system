<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;

class Address extends Model
{
    const BILLING_TYPE = 'billing';
    const SHIPPING_TYPE = 'shipping';

    protected $fillable = [
        'name',
        'address_street_1',
        'address_street_2',
        'city',
        'state',
        'country_id',
        'zip',
        'phone',
        'fax',
        'type',
        'addressable_id'
    ];

    /**
     * Get all of the owning addressable models.
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
