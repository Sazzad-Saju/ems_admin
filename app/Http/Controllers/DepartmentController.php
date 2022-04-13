<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $leaves = Leave::with('employee','leaveType','recommendEmployee','employee.approvedLeaves','employee.approvedLeaves.leaveType','recommendEmployee.approvedLeaves.leaveType')->latest()->get();
        $departments = Department::with('head','parentDepartment')->get();
        $employees = Employee::with('approvedLeaves','approvedLeaves.leaveType')->get();
//        $employees = [];
//        $leaveTypes = LeaveType::all();
//        $departments = Department::with('head','parentDepartment')->find(1);

//        dd($departments);
        return view('pages.department.index',compact('departments','employees'));

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'name'=>'required'
        ]);

        $data = $request->except('_token');

        Department::create($data);
        return redirect()->back()->with('success', trans('trans.create_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $this->validate($request,[
            'name'=>'required'
        ]);

        $data = $request->except('_token');

        $department->update($data);

        return redirect()->back()->with('success', trans('trans.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->back()->with('success', trans('trans.delete_successfully'));

    }


    public function statusUpdate(Department $department)
    {
        $departmentStatus = $department->status == 1 ? 0 : 1 ;
        $department->update(['status'=>$departmentStatus]);

        return redirect()->back()->with('success', trans('trans.update_successfully'));

    }


//    public function makeHead(Request $request)
//    {
//
//    }
}
