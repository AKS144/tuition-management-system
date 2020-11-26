<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tax;

class TaxType extends Model
{
    protected $fillable = [
        'name',
        'percent',
        'branch_id',
        'compound_tax',
        'collective_tax',
        'description'
    ];

    protected $casts = [
        'percent' => 'float'
    ];

    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }

    /**
     * Get the branch that owns the tax type.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('branch_id', $branch_id);
    }
}
