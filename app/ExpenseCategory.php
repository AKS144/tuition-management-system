<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = ['name', 'branch_id', 'description'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['amount', 'formattedCreatedAt'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Get the branch that owns the expense category.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
