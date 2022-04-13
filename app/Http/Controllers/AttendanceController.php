<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $attendances = Attendance::with('employee','employee.approvedLeaves','employee.approvedLeaves.leaveType')->latest()->get();
        $employees = Employee::with('approvedLeaves','approvedLeaves.leaveType')->get();
        return view('pages.attendance.index', compact( 'employees'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request->all());

        /* edo check for out time */

        $this->validate($request, [
            'employee_id' => 'required',
            'date' => 'required',
            'start_time' => 'sometimes',
        ]);

//        if(isset($request->isMultiAttendance)){
//            return redirect()->back()->with('error', 'Multi date attendance not setup yet');
//        }
        $data = $request->except('_token');
        /* Convert date time format form setting to database*/
        $data['date'] = databaseDateFormatFromSetting($request->date);

        /*check if there is already an attendance in same day*/
        $attendance = Attendance::where([['employee_id', '=', $request->employee_id], ['date', '=', $data['date']]])->first();

        if (!is_null($attendance)) {

            $this->update($request, $attendance);

            return redirect()->back()->with('success', trans('trans.update_successfully'));

        }


        $data['start_time'] = [databaseTimeFormatFromSetting($request->start_time)];
        if(isset($request->end_time)){
            $data['end_time'] = [databaseTimeFormatFromSetting($request->end_time)];
        }

        Attendance::create($data);

        return redirect()->back()->with('success', trans('trans.create_successfully'));


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {

        $this->validate($request, [
            'employee_id' => 'required',
            'date' => 'required',
            'start_time' => 'sometimes',
        ]);

        $data = $request->except('_token');

        $attendance->getOriginal('start_time');

        /* Convert date time format form setting to database*/
        $data['date'] = databaseDateFormatFromSetting($request->date);

        /* Update start time as json with existing with previous data */
        if(isset($request->start_time)) {
            $start_time = json_decode($attendance->getOriginal('start_time'));
            $start_time[] = databaseTimeFormatFromSetting($request->start_time);
            $data['start_time'] = $start_time;
        }else{
            unset($data['start_time']);
        }

        /* Update start time as json with existing with previous data */

        if(isset($request->end_time)){
            $end_time = json_decode($attendance->getOriginal('end_time'));
            $end_time[] = databaseTimeFormatFromSetting($request->end_time);
            $data['end_time'] = $end_time;
        }else{
            unset($data['end_time']);

        }

        $attendance->update($data);

        return redirect()->back()->with('success', trans('trans.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->back()->with('success', trans('trans.delete_successfully'));
    }

    public function getAttendanceData(Request $request)
    {
        $columns = array(
            0 => 'sl',
            1 => 'employee.profile_image',
            2 => 'employee.name',
            3 => 'employee.custom_id',
            4 => 'date',
            5 => 'start_time',
            6 => 'end_time',
            7 => 'late_time',
            8 => 'action',
        );
        $columnEscape = [0,1,2,3,7,8];

        $totalData = Attendance::count();

        $totalFiltered = $totalData;

        $columnIndex = $request->input('order.0.column');
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$columnIndex];
        $dir = $request->input('order.0.dir');

        if ($limit < 0) {
            $limit = $totalData;
        }

        if (in_array($columnIndex,$columnEscape)) {
            $order = 'date';
            $dir = 'asc';
        }

        if ($request->input('employeeId') || $request->input('dateRange')) {

            /* It will fire if there is any CUSTOM filter property */

            $employee_id = $request->input('employeeId');

            $attendances = new Attendance();

            if ($employee_id) {
                $attendances = $attendances->whereHas('employee', function ($q) use ($employee_id) {
                    $q->where('id', $employee_id);
                });
            }
            if ($request->input('dateRange')) {
                $dateRange = explode(' to ', $request->input('dateRange'));

                $startDate = databaseDateFormatFromSetting($dateRange[0]);
                $endDate = databaseDateFormatFromSetting($dateRange[1]);
                $attendances = $attendances->whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate]);
            }


            /* Update pagination after filter */
            $totalFiltered = $attendances->count();


            $attendances = $attendances->with('employee')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            /*if ($dir == 'asc') {
                $attendances = $attendances->with('employee')
                    ->offset($start)
                    ->limit($limit)
                    ->get()
                    ->sortBy($order);
            }else{
                $attendances = $attendances->with('employee')
                    ->offset($start)
                    ->limit($limit)
                    ->get()
                    ->sortByDesc($order);
            }*/

        } else {

            if (empty($request->input('search.value'))) {

                $attendances = Attendance::join('employees as employee', 'employee.id', '=', 'attendances.employee_id')
                    ->select('*')
                    ->with('employee')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            } else {

                /* It will fire if there is any DEFAULT filter property */

                $search = $request->input('search.value');

                if ($dir == 'asc') {
                    $attendances = Attendance::whereHas('employee', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('custom_id', 'like', '%' . $search . '%');
                    })->with('employee')
                        ->offset($start)
                        ->limit($limit)
                        ->get()
                        ->sortBy($order);

                } else {
                    $attendances = Attendance::whereHas('employee', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('custom_id', 'like', '%' . $search . '%');
                    })->with('employee')
                        ->offset($start)
                        ->limit($limit)
                        ->get()
                        ->sortByDesc($order);
                }
            }

        }


        $i = 0;
        $data = array();

        foreach ($attendances as $key => $attendance) {
            $i++;

            /* Profile image */
            $profileImage = '<img src="' . asset('asset/img/default.png') . '" class="circle-avatar" alt="attendance-avatar">';
            if ($attendance->employee->profile_image) {
                $profileImage = '<img src="' . asset($attendance->employee->profile_image) . '" class="circle-avatar" alt="attendance-avatar">';
            }

            /* Action Buttons */

            /* Pass data with button to use front-end edit option*/
            $edit_data = [
                'id'=>$attendance->id,
                'employee_id'=>$attendance->employee->id,
                'date'=>$attendance->date,
                'start_time'=>$attendance->start_time,
                'end_time'=>$attendance->end_time,
            ];

            $action = '<button onclick="getAttendanceEditInfo(event)" class="btn btn-sm btn-secondary" data-leave=\''.json_encode($edit_data).'\' data-toggle="tooltip" title="Edit attendance"><i class="fa fa-edit"></i></button>';

            /* Late Status */

            if ($attendance->late_time >=0) {
                $lateStatus =  "<span class='badge badge-success' style='width: 100%;max-width: 150px;font-size: 14px;font-weight: 400; padding: 5px 15px; border-radius: 2px;'>".$attendance->late_time."</span>";
            }else{
                $lateStatus =  "<span class='badge badge-danger' style='width: 100%;max-width: 150px;font-size: 14px;font-weight: 400; padding: 5px 15px; border-radius: 2px;'>".$attendance->late_time."</span>";
            }


            $nestedData['sl'] = $start+$i;
            $nestedData['profile_image'] = $profileImage;
            $nestedData['employee_name'] = $attendance->employee->name;
            $nestedData['employee_id'] = $attendance->employee->custom_id;
            $nestedData['date'] = showDate($attendance->date);
            $nestedData['start_time'] = showTime($attendance->start_time);
            $nestedData['end_time'] = showTime($attendance->end_time) ?: '--';
            $nestedData['late_time'] = $lateStatus;
            $nestedData['action'] = $action;
            $data[] = $nestedData;

        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);


    }
}
