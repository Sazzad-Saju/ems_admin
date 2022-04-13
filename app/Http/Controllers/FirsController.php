<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Employee;
use App\Models\Report;
use Illuminate\Http\Request;

class FirsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reports = Report::with('employee')->latest()->get();
        $employees = Employee::all();

        return view('pages.firs.index',compact('reports','employees'));
//        dd('Working');
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
            'employee_id'=>'required',
            'level'=>'required',
            'description'=>'required',
            'date'=>'required|date',
        ]);

        $data = $request->except('_token');
        $data['created_by']= Auth::user()->id;

        /* Convert setting date format to database date format */
        $data['date'] = databaseDateFormatFromSetting($request->date);

        Report::create($data);

        return redirect()->back()->with('success', trans('trans.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Report $fir
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Report $fir)
    {

        $this->validate($request,[
            'employee_id'=>'required',
            'level'=>'required',
            'description'=>'required',
            'date'=>'required|date',
        ]);

        $data = $request->except('_token');
        $data['updated_by']= Auth::user()->id;

        /* Convert setting date format to database date format */
        $data['date'] = databaseDateFormatFromSetting($request->date);

        $fir->update($data);

        return redirect()->back()->with('success', trans('trans.update_successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $fir)
    {
        $fir->delete();

        return redirect()->back()->with('success', trans('trans.delete_successfully'));
    }
}
