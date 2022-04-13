<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaves = Leave::with(
            'employee',
            'leaveType',
            'recommendEmployee',
            'employee.approvedLeaves',
            'employee.approvedLeaves.leaveType',
            'recommendEmployee.approvedLeaves.leaveType'
        )->latest()->get();
        $employees = Employee::with('approvedLeaves', 'approvedLeaves.leaveType')->get();
        $leaveTypes = LeaveType::all();
//        dd($leaves->first()->employee->leave_duration);
        return view('pages.leave.index', compact('leaves', 'employees', 'leaveTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'employee_id' => 'required',
                'submission_type' => 'required',
                'leave_type_id' => 'required',
                'reason' => 'required',
                'leave_time' => 'required',
                'recommend_employee_id' => 'required',
            ]
        );

        $leaveDate = explode(' - ', $request->leave_time);

        $leaveStartDayTime = databaseDateTimeObjectFromSetting($leaveDate[0]);
        $leaveEndDayTime = databaseDateTimeObjectFromSetting($leaveDate[1]);

        $leaveStartDate = $leaveStartDayTime->format('Y-m-d');
        $leaveStartTime = $leaveStartDayTime->format('H:i:s');

        $leaveEndDate = $leaveEndDayTime->format('Y-m-d');
        $leaveEndTime = $leaveEndDayTime->format('H:i:s');


        /* Check valid start office hour*/
        $cOfficeStartTime = Carbon::parse(settings('office_start_hour'));
        $cLeaveStartTime = Carbon::parse($leaveStartTime);
        $startTimeDiff = $cOfficeStartTime->diff($cLeaveStartTime);
        if ($startTimeDiff->format("%r%a") === "-0") {
            return back()->with(
                'error',
                trans(
                    'trans.select_valid_leave_start_time',
                    ['OfficeStartTime' => $cOfficeStartTime->format('h:i:a')]
                )
            );
        }

        /* Check valid start office hour*/
        $cOfficeEndTime = Carbon::parse(settings('office_end_hour'));
        $cLeaveEndTime = Carbon::parse($leaveEndTime);
        $endTimeDiff = $cLeaveEndTime->diff($cOfficeEndTime);
        if ($endTimeDiff->format("%r%a") === "-0") {
            return redirect()->back()->with(
                'error',
                trans(
                    'trans.select_valid_leave_end_time',
                    ['OfficeEndTime' => $cOfficeEndTime->format('h:i:a')]
                )
            );
        }

        $leaveDuration = $this->leaveDuration($leaveStartDayTime, $leaveEndDayTime);


        $data = $request->except('_token', 'leave_time');
        $data['start_date'] = $leaveStartDate;
        $data['end_date'] = $leaveEndDate;
        $data['start_time'] = $leaveStartTime;
        $data['end_time'] = $leaveEndTime;
        $data['created_by'] = Auth::user()->id;
        $data['duration'] = $leaveDuration;
        $data['status'] = 'Pending';

        Leave::create($data);

        return redirect()->back()->with('success', trans('trans.create_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Leave $leave
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Leave $leaf)
    {
        $leave = $leaf;

        $this->validate(
            $request,
            [
                'employee_id' => 'required',
                'submission_type' => 'required',
                'leave_type_id' => 'required',
                'reason' => 'required',
                'leave_time' => 'required',
                'recommend_employee_id' => 'required',
                'status' => 'required',
            ]
        );

        $leaveDate = explode(' - ', $request->leave_time);

        $leaveStartDayTime = databaseDateTimeObjectFromSetting($leaveDate[0]);
        $leaveEndDayTime = databaseDateTimeObjectFromSetting($leaveDate[1]);


        $leaveStartDate = $leaveStartDayTime->format('Y-m-d');
        $leaveStartTime = $leaveStartDayTime->format('H:i:s');

        $leaveEndDate = $leaveEndDayTime->format('Y-m-d');
        $leaveEndTime = $leaveEndDayTime->format('H:i:s');

        /* Check valid start office hour*/
        $cOfficeStartTime = Carbon::parse(settings('office_start_hour'));
        $cLeaveStartTime = Carbon::parse($leaveStartTime);
        $startTimeDiff = $cOfficeStartTime->diff($cLeaveStartTime);
        if ($startTimeDiff->format("%r%a") === "-0") {
            return back()->with(
                'error',
                trans(
                    'trans.select_valid_leave_start_time',
                    ['OfficeStartTime' => $cOfficeStartTime->format('h:i:a')]
                )
            );
        }

        /* Check valid end office hour*/
        $cOfficeEndTime = Carbon::parse(settings('office_end_hour'));
        $cLeaveEndTime = Carbon::parse($leaveEndTime);
        $endTimeDiff = $cLeaveEndTime->diff($cOfficeEndTime);
        if ($endTimeDiff->format("%r%a") === "-0") {
            return redirect()->back()->with(
                'error',
                trans(
                    'trans.select_valid_leave_end_time',
                    ['OfficeEndTime' => $cOfficeEndTime->format('h:i:a')]
                )
            );
        }

        $leaveDuration = $this->leaveDuration($leaveStartDayTime, $leaveEndDayTime);


        $data = $request->except('_token', 'leave_time');
        $data['start_date'] = $leaveStartDate;
        $data['end_date'] = $leaveEndDate;
        $data['start_time'] = $leaveStartTime;
        $data['end_time'] = $leaveEndTime;
        $data['updated_by'] = Auth::user()->id;
        $data['duration'] = $leaveDuration;

        $leave->update($data);

        return redirect()->back()->with('success', trans('trans.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leaf)
    {
        $leave = $leaf;

        $leave->delete();

        return redirect()->back()->with('success', trans('trans.delete_successfully'));
    }

    public function calendarView()
    {
        $leaves = Leave::with(
            'employee',
            'leaveType',
            'recommendEmployee',
            'employee.department',
            'employee.designation',
            'employee.departmentHead',
            'employee.approvedLeaves',
            'employee.approvedLeaves.leaveType',
            'recommendEmployee.approvedLeaves.leaveType'
        )->where('status', 'Approved')->latest()->get();

        $employees = Employee::with(
            'approvedLeaves',
            'approvedLeaves.leaveType',
            'department',
            'designation',
            'departmentHead'
        )->get();

        return view('pages.leave.calendar', compact('leaves', 'employees'));
    }

    public function leaveDuration($startDayTime, $endDayTime)
    {
        if ($startDayTime->format('Y-m-d') == $endDayTime->format('Y-m-d')) {
            $duration = $startDayTime->diffInMinutes($endDayTime);
        } else {
            /* First day leave hour*/
            $officeEndTime = Carbon::parse(settings('office_end_hour'));
            $leaveStartTime = Carbon::parse($startDayTime->format('H:i:s'));
            $firstDayLeaveInMin = $officeEndTime->diffInMinutes(
                $leaveStartTime
            ); /*end office hour - leave start of first date*/

            /* Last day leave hour*/
            $leaveEndTime = Carbon::parse($endDayTime->format('H:i:s'));
            $officeStartTime = Carbon::parse(settings('office_start_hour'));
            $LastDayLeaveInMin = $leaveEndTime->diffInMinutes($officeStartTime);  /*leave end time - office start time*/

            /* Rest of the day leave hour*/
            $startDate = Carbon::parse($startDayTime->format('Y-m-d'));
            $endDate = Carbon::parse($endDayTime->format('Y-m-d'));
            $totalLeaveDayInMin = (($endDate->diffInDays(
                        $startDate
                    )) - 1) * 9 * 60; /* -1 for subtract first day and last day */

            $duration = $firstDayLeaveInMin + $LastDayLeaveInMin + $totalLeaveDayInMin;
        }

        return $duration;
    }
}
