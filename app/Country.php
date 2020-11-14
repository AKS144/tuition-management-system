<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function address()
    {
        return $this->hasMany(Address::class);
    }
}
