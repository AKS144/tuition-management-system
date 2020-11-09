<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estimate;

class EstimateTemplate extends Model
{
    protected $fillable = ['path', 'view', 'name'];

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    public function getPathAttribute($value)
    {
        return url($value);
    }
}
