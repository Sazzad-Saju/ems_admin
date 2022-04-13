<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\loan;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with('approvedLeaves','approvedLeaves.leaveType')->get();
        $loans = Loan::with('employee','employee.approvedLeaves','employee.approvedLeaves.leaveType')->latest()->get();

        return view('pages.loan.index',compact('loans','employees'));
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
            'reason'=>'required',
            'amount'=>'required|numeric',
            'issue_date'=>'required',
        ]);

        $data = $request->except('_token');

        $data['created_by']= Auth::user()->id;

        /* Convert setting date format to database date format*/
        $data['issue_date'] = databaseDateFormatFromSetting($request->issue_date);
        if (isset($request->return_date)){
            $data['return_date'] = databaseDateFormatFromSetting($request->return_date);
        }

        Loan::create($data);

        return redirect()->back()->with('success', trans('trans.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, loan $loan)
    {
        $this->validate($request,[
            'employee_id'=>'required',
            'reason'=>'required',
            'amount'=>'required|numeric',
            'issue_date'=>'required',
        ]);

        $data = $request->except('_token');
        $data['updated_by']= Auth::user()->id;

        /* Convert setting date format to database date format*/
        $data['issue_date'] = databaseDateFormatFromSetting($request->issue_date);
        if (isset($request->return_date)){
            $data['return_date'] = databaseDateFormatFromSetting($request->return_date);
        }

        $loan->update($data);

        return redirect()->back()->with('success', trans('trans.create_successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(loan $loan)
    {
        $loan->delete();

        return redirect()->back()->with('success', trans('trans.delete_successfully'));

    }
}
