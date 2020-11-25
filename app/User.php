<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Carbon\Carbon;
use App\BranchSetting;
use App\Currency;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasApiTokens, HasRoles, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 
        'email', 
        'password', 
        'is_active', 
        // 'role_id', 
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'currency'
    ];

    protected $appends = [
        'formattedCreatedAt',
        // 'avatar'
    ];

    /**
     * Get the branch associated with the user
     */
    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the payments associated with the user
     */
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function getFormattedCreatedAtAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->created_at)->format($dateFormat);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeWhereOrder($query, $orderByField, $orderBy)
    {
        $query->orderBy($orderByField, $orderBy);
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->where(function ($query) use ($term) {
                $query->where('name', 'LIKE', '%'.$term.'%');
            });
        }
    }
}
