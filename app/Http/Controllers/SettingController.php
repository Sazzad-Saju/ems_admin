<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->getAllSettings();
        $timezones = timezone_identifiers_list();
        return view('pages.setting.index',compact('settings','timezones'));
    }

    /**
     * @return mixed
     */
    protected function getAllSettings()
    {
        $key = "settings.get";
        return Cache::remember($key, 24 * 60, function () {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, setting $setting)
    {
        $this->validate($request, [
            'app_name' => 'sometimes|required|string|max:255',
//            'app_url' => 'required|string|max:200',
        ]);

        $values = $request->except('_token');

        // Set ...
//        $request->has('ip_stack') ? $values['ip_stack'] = 1 : $values['ip_stack'] = 0;

        foreach ($values as $key => $value) {
            if($key == 'office_start_hour'){
                $value = databaseTimeFormatFromSetting($value);
                Setting::where('key', $key)->update(['value' => $value]);
                continue;
            }
            if($key == 'office_end_hour'){
                $value = databaseTimeFormatFromSetting($value);
                Setting::where('key', $key)->update(['value' => $value]);
                continue;
            }
            Setting::where('key', $key)->update(['value' => $value]);
        }

        Artisan::call('cache:clear');

        return redirect()->back()->with('success', trans('trans.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(setting $setting)
    {
        //
    }
}
