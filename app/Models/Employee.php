<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use SoftDeletes, Notifiable;

    protected $guarded = [];

    protected $appends = ['leave_duration','leave_duration_in_minute'];

    /**
     *  Relation between Employee and blood group
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class);
    }

    /**
     * Relation between Employee and Department group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relation between Employee and Designation group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function designation()
    {
        return $this->belongsTo(Designation::class);

    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);

    }

    public function approvedLeaves()
    {
        return $this->hasMany(Leave::class)->where('status', 'Approved');

    }

    public function getLeaveDurationAttribute()
    {
        $leaveDuration = [];
        $approvedLeave = $this->approvedLeaves ;
//        $approvedLeave->load('leaveType');

        foreach ($approvedLeave as $leave) {
            if (!isset($leaveDuration[$leave->leaveType->name])) {
                $leaveDuration[$leave->leaveType->name] = 0;
            }
            $leaveDuration[$leave->leaveType->name] = $leaveDuration[$leave->leaveType->name] + $leave->duration;
        }

        foreach ($leaveDuration as $k => $v) {
            $leaveDuration[$k] = humanReadableDayFromMins((int)$v);
        }

        return $leaveDuration;
    }
    public function getLeaveDurationArrayAttribute()
    {
        $leaveDuration = [];

        foreach ($this->approvedLeaves as $leave) {
            if (!isset($leaveDuration[$leave->leaveType->name])) {
                $leaveDuration[$leave->leaveType->name] = 0;
            }
            $leaveDuration[$leave->leaveType->name] = $leaveDuration[$leave->leaveType->name] + $leave->duration;
        }

        foreach ($leaveDuration as $k => $v) {
            $leaveDuration[$k] = humanReadableDayFromMinsArray((int)$v);
        }

        return $leaveDuration;
    }
    public function getLeaveDurationInMinuteAttribute()
    {
        $leaveDuration = [];

        foreach ($this->approvedLeaves as $leave) {
            if (!isset($leaveDuration[$leave->leaveType->name])) {
                $leaveDuration[$leave->leaveType->name] = 0;
            }
            $leaveDuration[$leave->leaveType->name] = $leaveDuration[$leave->leaveType->name] + $leave->duration;
        }

        return $leaveDuration;
    }


    public function departmentHead()
    {
        return $this->hasMany(Department::class);
    }


}
