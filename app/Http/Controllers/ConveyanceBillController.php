<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\BillType;
use App\Models\ConveyanceBill;
use App\Models\Employee;
use Illuminate\Http\Request;

class ConveyanceBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conveyanceBills = ConveyanceBill::with('employee','billType','employee.approvedLeaves','employee.approvedLeaves.leaveType')->latest()->get();
        $employees = Employee::with('approvedLeaves','approvedLeaves.leaveType')->get();
        $billTypes = BillType::all();
        return view('pages.conveyance_bill.index',compact('conveyanceBills','employees','billTypes'));

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            "bill_type_id" => "required",
            "description" => "required",
            "amount" => "required",
            "date" => "required",
        ]);

        $data = $request->except('_token');

        $data['date']= databaseDateFormatFromSetting($request->date);
        $data['is_approved'] = $request->is_approved ? 1 : 0;
        $data['created_by']= Auth::user()->id;

        ConveyanceBill::create($data);

        return redirect()->back()->with('success', trans('trans.create_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConveyanceBill  $conveyanceBill
     * @return \Illuminate\Http\Response
     */
    public function show(ConveyanceBill $conveyanceBill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConveyanceBill  $conveyanceBill
     * @return \Illuminate\Http\Response
     */
    public function edit(ConveyanceBill $conveyanceBill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConveyanceBill  $conveyanceBill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConveyanceBill $conveyanceBill)
    {
//        dd($conveyanceBill);
        $this->validate($request,[
            "bill_type_id" => "required",
            "description" => "required",
            "amount" => "required",
            "date" => "required",
        ]);

        $data = $request->except('_token');

        $data['date']= databaseDateFormatFromSetting($request->date);
        $data['is_approved'] = $request->is_approved ? 1 : 0;
        $data['updated_by']= Auth::user()->id;

        $conveyanceBill->update($data);

        return redirect()->back()->with('success', trans('trans.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConveyanceBill  $conveyanceBill
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConveyanceBill $conveyanceBill)
    {
        $conveyanceBill->delete();

        return redirect()->back()->with('success', trans('trans.delete_successfully'));
    }

    public function statusUpdate(ConveyanceBill $conveyanceBill)
    {
        $status = $conveyanceBill->is_approved == 1 ? 0 : 1 ;
        $conveyanceBill->update(['is_approved'=>$status]);
        return redirect()->back()->with('success', trans('trans.update_successfully'));
    }
}
