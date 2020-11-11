<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchSetting extends Model
{
    protected $fillable = ['branch_id', 'option', 'value'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public static function setSetting($key, $setting, $branch_id)
    {
        $old = self::whereOption($key)->whereBranch($branch_id)->first();

        if ($old) {
            $old->value = $setting;
            $old->save();
            return;
        }

        $set = new BranchSetting();
        $set->option = $key;
        $set->value = $setting;
        $set->branch_id = $branch_id;
        $set->save();
    }

    public static function getSetting($key, $branch_id)
    {
        $setting = static::whereOption($key)->whereBranch($branch_id)->first();

        if ($setting) {
            return $setting->value;
        } else {
            return null;
        }
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('branch_id', $branch_id);
    }
}
