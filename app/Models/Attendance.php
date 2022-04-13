<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'start_time' => 'array',
        'end_time' => 'array'
    ];
    /**
     * Relation between attendance and employee
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getStartTimeAttribute($value)
    {
        $start_time = json_decode($value);
        return $start_time[0];
    }
    public function getEndTimeAttribute($value)
    {
        $value = json_decode($value);
        $start_time = collect($value);
        return $start_time->last();
    }

    public function getLateTimeAttribute()
    {
        $date = $this->date;
        $officeStartHour = settings('office_start_hour');
        $presentHour = $this->start_time;
        $OfficeStart = Carbon::parse($date . ' ' . $officeStartHour )->addMinute(settings('flexible_time'));
        $presentAt = Carbon::parse($date . ' ' . $presentHour );
        return $presentAt->diffInMinutes($OfficeStart,false);

    }
}
