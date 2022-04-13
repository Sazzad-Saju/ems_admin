<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays = Holiday::oldest('start')->get();
//        $googleEvens = $this->googleEvents(); //import google event
        $googleEvens = [];
//        return view('pages.holiday.index',compact('holidays'));
        return view('pages.holiday.index',compact('holidays','googleEvens'));
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
//        dd($request->all());

        $this->validate($request,[
            'start'=>'required',
            'title'=>'required',
            'type'=>'required'
        ]);

        /*Create google event*/
//        if(isset($request->addToGoogle)){
//            $this->addGoogleEvent($request);
//        }


        $data =  $request->except('_token');

        /* Convert setting date format to database date format*/
        $data['start'] = databaseDateFormatFromSetting($request->start);

        Holiday::create($data);

        return redirect()->back()->with('success', trans('trans.create_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        $this->validate($request,[
            'start'=>'required',
            'title'=>'required',
            'type'=>'required'
        ]);

        $data =  $request->except('_token');

        /* Convert setting date format to database date format*/
        $data['start'] = databaseDateFormatFromSetting($request->start);

        $holiday->update($data);

        return redirect()->back()->with('success', trans('trans.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return redirect()->back()->with('success', trans('trans.delete_successfully'));

    }

    public function googleEvents()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAuthConfig(Config::get("googleCalendar.credential"));
        $client->setAccessType('offline');

        $service = new Google_Service_Calendar($client);

        $calendarId = 'en.bd#holiday@group.v.calendar.google.com';
        $optParams = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        );
        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        if (empty($events)) {
            return [];
        } else {
            return $events;
        }
    }

    public function addGoogleEvent($request)
    {
        $client = new Google_Client();
        $client->setApplicationName('mycal');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig(Config::get("googleCalendar.credential"));
        $client->setAccessType('offline');

        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event(array(
            'summary' => $request->title,
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => array(
                'date' => Carbon::parse(databaseDateFormatFromSetting($request->start))->format('Y-m-d'),
                'timeZone' => settings('timezone'),
            ),
            'end' => array(
                'date' => Carbon::parse(databaseDateFormatFromSetting($request->start))->format('Y-m-d'),
                'timeZone' => settings('timezone'),
            ),

        ));

        $calendarId = 'rabbialrabbi@gmail.com';
        $event = $service->events->insert($calendarId, $event);
        printf('Event created: %s\n', $event->htmlLink);
    }
}
