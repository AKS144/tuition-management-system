<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Branch;
use App\Expense;

class ExpenseCategory extends Model
{
    protected $fillable = ['name', 'branch_id', 'description'];

    /**
     * Get the branch that owns the expense category.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the expense that owns the expense category.
     */
    public function expenses()
    {
        return $this->belongsTo(Expense::class);
    }
}
