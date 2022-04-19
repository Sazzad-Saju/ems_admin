<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Notice;
use App\Models\Department;
use App\Notifications\NotifyNotice;
use Carbon\Carbon;
use Google\Service\AlertCenter\Notification;
use Illuminate\Http\Request;
use Mockery\Matcher\Not;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notice::select(['id','message','created_at'])->orderBy('created_at','desc')->paginate(5);
        $date = Carbon::now();
        // return $notices;
        return view('pages.notice.index',compact('notices','date'));
        return view('pages.notice.notice');
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
        // return $request->all();
        //// Employee::find(Auth('employee')->user()->id)->notify(new LatestNotice);
        $request->validate(['message' => 'required']);
        $data = $request->only(['message']);
        $today = Carbon::now('Asia/Dhaka')->toDateTimeString();
        $data['created_at'] = $today;
        $data['created_by'] = 1;
        $notice = Notice::create($data);

        $employees = Employee::all();
        foreach($employees as $employee){
            $employee->notify(new NotifyNotice($notice->message));
        }
        return redirect()->back()->with('success', trans('trans.create_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        $data = $request->only(['message']);
        $today = Carbon::now('Asia/Dhaka')->toDateTimeString();
        $data['updated_at'] = $today;
        $data['updated_by'] = 1;
        $notice->update($data);
        return redirect()->back()->with('success', trans('trans.update_successfully'));
        // return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        // This delete data of all employee from notification table for that notice
        $message =  $notice['message'];
        $employees = Employee::all();
        foreach($employees as $employee){
            $employee->notifications()->where('data->data', $message)->delete();
        }

        // delete notice
        $notice->delete();
        return redirect()->back()->with('success', trans('trans.delete_successfully'));
    }
}
