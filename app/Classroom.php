<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\BranchSetting;

class Classroom extends Model
{
    protected $table = 'classrooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 
        'name', 
        'batch_year',
        'tutor_id', 
        'branch_id',
    ];

    protected $appends = [
        'formattedJoinedAt',
    ];

    public function getFormattedJoinedAtAttribute($value)
    {
        $dateFormat = BranchSetting::getSetting('carbon_date_format', $this->branch_id);
        return Carbon::parse($this->date_joined)->format($dateFormat);
    }

    /**
     * Get the tutor associated with the classroom
     */
    public function tutor(){
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Get the student associated with the classroom
     */
    public function student(){
        return $this->belongsToMany(Student::class, 'classroom_student');
    }

    /**
     * Get the branch associated with the classroom
     */
    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the schedule associated with the classroom
     */
    public function schedule(){
        return $this->belongsToMany(Schedule::class, 'classroom_schedule');
    }

    public function scopeWhereBranch($query, $branch_id)
    {
        $query->where('classrooms.branch_id', $branch_id);
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

    public function scopeWhereName($query, $full_name)
    {
        return $query->where('name', 'LIKE', '%'.$full_name.'%');
    }

    public function scopeWhereCode($query, $code)
    {
        return $query->where('classrooms.code', 'LIKE', '%'.$code.'%');
    }

    public function scopeWhereTutor($query, $tutor_id)
    {
        return $query->where('classrooms.tutor_id', 'LIKE', '%'.$tutor_id.'%');
    }

    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);

        if ($filters->get('search')) {
            $query->whereSearch($filters->get('search'));
        }

        if ($filters->get('name')) {
            $query->whereName($filters->get('name'));
        }

        if ($filters->get('code')) {
            $query->whereCode($filters->get('code'));
        }

        if ($filters->get('tutor_id')) {
            $query->whereTutor($filters->get('tutor_id'));
        }

        if ($filters->get('orderByField') || $filters->get('orderBy')) {
            $field = $filters->get('orderByField') ? $filters->get('orderByField') : 'full_name';
            $orderBy = $filters->get('orderBy') ? $filters->get('orderBy') : 'asc';
            $query->whereOrder($field, $orderBy);
        }
    }
}
