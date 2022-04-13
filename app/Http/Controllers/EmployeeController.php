<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\BloodGroup;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('bloodGroup','department','designation','approvedLeaves','approvedLeaves.leaveType','departmentHead')->latest()->get();
        $departments = Department::where('status',1)->get();
        $designations = Designation::all();
        $bloodGroups = BloodGroup::all();
//        dd($employees);

        return view('pages.employee.index',compact('employees','departments','designations','bloodGroups'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('Working');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->except(['_token','first_name','last_name']));

        $this->validate($request,[
            'first_name'=>'required|max:30',
            'last_name'=>'max:30',
            'personal_email'=>'required',
            'phone'=>'required',
            'office_phone'=>'required',
            'present_address'=>'required',
            'permanent_address'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'blood_group_id'=>'required',
            'department_id'=>'required',
            'designation_id'=>'required',
            'emergency_contact_person'=>'required|max:30',
            'emergency_contact_phone'=>'required',
            'emergency_contact_address'=>'required',
            'emergency_contact_relation'=>'required',
            'nid_number'=>'required|min:6|max:12',
            'salary'=>'required',
            'join_date'=>'required',
            'profile_image'=>'required|image|mimes:jpeg,png,jpg|max:1024',
            'certificate_image'=>'required|image|mimes:jpeg,png,jpg|max:1024',
            'nid_image'=>'required|image|mimes:jpeg,png,jpg|max:1024',

        ]);



        $data = $request->except(['_token','first_name','last_name']);

        /* Convert Date format from setting format to database format */
        $dateFormatFromSetting = getDateFormat();
        $data['dob'] = Carbon::createFromFormat($dateFormatFromSetting, $request->dob);
        $data['join_date'] = Carbon::createFromFormat($dateFormatFromSetting, $request->join_date);
        if (isset($request->quit_date)){
            $data['quit_date'] = Carbon::createFromFormat($dateFormatFromSetting, $request->quit_date);
        }


        $data['name'] = $request->first_name . " ". $request->last_name;
        $data['is_current_employee'] = $request->is_current_employee ? 1 : 0 ;
        $data['is_provision_period'] = $request->is_provision_period ? 1 : 0 ;
        $data['created_by']= Auth::user()->id;


        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $image->storePubliclyAs('public/img/profile_image', $name);
            $image_path = "storage/img/profile_image/" . $name;
            $data['profile_image'] = $image_path;
        }

        if ($request->hasFile('certificate_image')) {
            $image = $request->file('certificate_image');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $image->storePubliclyAs('public/img/certificate_image', $name);
            $image_path = "storage/img/certificate_image/" . $name;
            $data['certificate_image'] = $image_path;
        }

        if ($request->hasFile('nid_image')) {
            $image = $request->file('nid_image');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $image->storePubliclyAs('public/img/nid_image', $name);
            $image_path = "storage/img/nid_image/" . $name;
            $data['nid_image'] = $image_path;
        }


        $employee = Employee::create($data);

        /* Create and update delivery custom id*/
//        $deliveryId = settings('order_prefix') .'D'. str_pad($employee->id, 7, '0', STR_PAD_LEFT).settings('order_suffix'); // edu Update Setting
        $customID = "NC-" . str_pad($employee->id, 4, '0', STR_PAD_LEFT);

        $updateEmployee = $employee->update(['custom_id'=> $customID]);

        return redirect()->back()->with('success', trans('trans.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
//        dd($request->all());
        $this->validate($request,[
            'first_name'=>'required|max:30',
            'last_name'=>'max:30',
            'personal_email'=>'required',
            'phone'=>'required',
            'office_phone'=>'required',
            'present_address'=>'required',
            'permanent_address'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'blood_group_id'=>'required',
            'department_id'=>'required',
            'designation_id'=>'required',
            'emergency_contact_person'=>'required|max:30',
            'emergency_contact_phone'=>'required',
            'emergency_contact_address'=>'required',
            'emergency_contact_relation'=>'required',
            'nid_number'=>'required|min:6|max:12',
            'salary'=>'required',
            'join_date'=>'required',
        ]);

        $data = $request->except(['_token','first_name','last_name']);

        /* Convert Date format from setting format to database format */
        $dateFormatFromSetting = getDateFormat();
        $data['dob'] = Carbon::createFromFormat($dateFormatFromSetting, $request->dob);
        $data['join_date'] = Carbon::createFromFormat($dateFormatFromSetting, $request->join_date);
        if (isset($request->quit_date)){
            $data['quit_date'] = Carbon::createFromFormat($dateFormatFromSetting, $request->quit_date);
        }

        $data['name'] = $request->first_name . " ". $request->last_name;
        $data['is_current_employee'] = $request->is_current_employee ? 1 : 0 ;
        $data['is_provision_period'] = $request->is_provision_period ? 1 : 0 ;
        $data['updated_by']= Auth::user()->id;


        if ($request->hasFile('profile_image')) {

            $file_path = public_path($employee->profile_image);

            if (file_exists($file_path) && !empty($employee->profile_image)) {
                unlink($file_path);
            }

            $image = $request->file('profile_image');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $image->storePubliclyAs('public/img/profile_image', $name);
            $image_path = "storage/img/profile_image/" . $name;
            $data['profile_image'] = $image_path;

        }else{
            $data['profile_image'] = $employee->profile_image;
        }

        if ($request->hasFile('nid_image')) {

            $file_path = public_path($employee->nid_image);

            if (file_exists($file_path) && !empty($employee->nid_image)) {
                unlink($file_path);
            }

            $image = $request->file('nid_image');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $image->storePubliclyAs('public/img/nid_image', $name);
            $image_path = "storage/img/nid_image/" . $name;
            $data['nid_image'] = $image_path;
        }else{
            $data['nid_image'] = $employee->nid_image;
        }

        if ($request->hasFile('certificate_image')) {

            $file_path = public_path($employee->certificate_image);

            if (file_exists($file_path) && !empty($employee->certificate_image)) {
                unlink($file_path);
            }

            $image = $request->file('certificate_image');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $image->storePubliclyAs('public/img/certificate_image', $name);
            $image_path = "storage/img/certificate_image/" . $name;
            $data['certificate_image'] = $image_path;
        }else{
            $data['certificate_image'] = $employee->certificate_image;
        }

        $employee->update($data);

        return redirect()->back()->with('success', trans('trans.update_successfully'));





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->back()->with('success', trans('trans.delete_successfully'));
    }

    public function statusUpdate(Employee $employee)
    {
        $employeeStatus = $employee->is_current_employee == 1 ? 0 : 1 ;
        $employee->update(['is_current_employee'=>$employeeStatus]);

        return redirect()->back()->with('success', trans('trans.update_successfully'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * Find the department employee going to assign as admin
     * Check is the department has already assigned any admin and create new entity for false
     * Find the pivot row and update
     */
    public function makeHeadOfDepartment(Request $request)
    {
        /* $request->department_id return an array as it is use select2 to select multiply department*/
        $departments = $request->department_id;

        foreach ($departments as $department){
            $department = Department::find($department);
            $department->update(['employee_id'=>$request->employee_id]);
        }


        return redirect()->back()->with('success', trans('trans.update_successfully'));
    }
}
