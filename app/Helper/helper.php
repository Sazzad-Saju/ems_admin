<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

/**
 * @param $key
 * @return mixed
 */
function settings($key)
{
    static $settings;

    if (is_null($settings)) {
        $settings = \Illuminate\Support\Facades\Cache::remember('settings', 24 * 60, function () {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });
    }

    return (is_array($key)) ? \Illuminate\Support\Arr::only($settings, $key) : $settings[$key];
}


//////////////////////////////////////////////////////////////////////// Date helper function starts
/*
 *  Used to check whether date is valid or not
 *  @param
 *  $date as timestamp or date variable
 *  @return true if valid date, else if not
 */

function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/*
 *  Used to convert date for database
 *  @param
 *  $date as date
 *  @return date
 */

function toDate($date)
{
    if (!$date) {
        return;
    }

    return date('Y-m-d', strtotime($date));
}


/*
 *  Used to get date in desired format
 *  @return date format
 */

function getDateFormat()
{
    if (settings('date_format') === 'DD-MM-YYYY') {
        return 'd-m-Y';
    } elseif (settings('date_format') === 'MM-DD-YYYY') {
        return 'm-d-Y';
    } elseif (settings('date_format') === 'DD-MMM-YYYY') {
        return 'd-M-Y';
    } elseif (settings('date_format') === 'MMM-DD-YYYY') {
        return 'M-d-Y';
    } else {
        return 'd-m-Y';
    }
}

/*
 *  Used to get Time in desired format
 *  @return date format
 */
function getTimeFormat()
{
    if (settings('time_format') === 'H:mm') {
        return 'H:i';
    } else {
        return 'h:i a';
    }
}

/*
 *  Used to convert date in desired format
 *  @param
 *  $date as date
 *  @return date
 */

function showDate($date)
{
    if (!$date) {
        return;
    }

    $date_format = getDateFormat();
    return date($date_format, strtotime($date));
}

/*
 *  Used to convert time in desired format
 *  @param
 *  $datetime as datetime
 *  @return datetime
 */

function showDateTime($time = '')
{
    if (!$time) {
        return;
    }

    $date_format = getDateFormat();
    if (settings('time_format') === 'H:mm') {
        return date($date_format . ' H:i', strtotime($time));
    } else {
        return date($date_format . ' h:i a', strtotime($time));
    }
}

/*
 *  Used to convert time in desired format
 *  @param
 *  $time as time
 *  @return time
 */

function showTime($time = '')
{
    if (!$time) {
        return;
    }

    if (settings('time_format') === 'H:mm') {
        return date('H:i', strtotime($time));
    } else {
        return date('h:i a', strtotime($time));
    }
}

/*
 *  Used to convert date &time in desired format
 *  @param
 *  $time as time
 *  @return time
 */

function showDiffForHuman($time = '')
{
    if (!$time) {
        return;
    }
    return \Illuminate\Support\Carbon::parse($time)->diffForHumans();
}

/*
 * Used to timestamp to day time and date format
 * @param
 * $time as time
 * @return time
 */
function showDayTimeDate($time = '')
{
    if (!$time) {
        return;
    }
    return \Illuminate\Support\Carbon::parse($time)->isoFormat('LLLL'); // 'Tuesday, July 23, 2019 2:51 PM';
}

function imagePath($image_name = null)
{
    return asset('storage/images/' . $image_name);
}

function humanReadableDayFromMins($mins)
{

    $hours = str_pad(floor($mins / 60), 2, "0", STR_PAD_LEFT);
    $mins = str_pad($mins % 60, 2, "0", STR_PAD_LEFT);

    if ((int)$hours >= 9) {
        $days = str_pad(floor($hours / 9), 2, "0", STR_PAD_LEFT);
        $hours = str_pad($hours % 9, 2, "0", STR_PAD_LEFT);
    }
    if ($mins == "00") {
        $mins = "";
    } else {
        $mins = $mins . " M[s]";
    }
    if ($hours == "00") {
        $hours = "";
    } else {
        $hours = $hours . " H[s] ";
    }
    if (isset($days)) {
        $days = $days . " D[s] ";
    } else {
        $days = "";
    }

    return $days . $hours . $mins;

}

function humanReadableDayFromMinsArray($mins)
{

    $hours = floor($mins / 60);
    $mins = $mins % 60;

    if ((int)$hours >= 9) {
        $days = floor($hours / 9);
        $hours = $hours % 9;
    }

    if (isset($days)) {
        $time['days'] = $days;
    } else {
        $time['days'] = "";
    }
    if ($hours == "00") {
        $time['hours'] = '';
    } else {
        $time['hours'] = $hours;
    }
    if ($mins == "00") {
        $time['mins'] = '';
    } else {
        $time['mins'] = $mins;
    }
    return $time;

}

/*
 * Take: Date of setting format
 * Return: Date of database format
 * Dependency: helper function getDateFormat()
 */
function databaseDateFormatFromSetting($date)
{
    if (!$date) {
        return;
    }

    $dateFormatFromSetting = getDateFormat();
    return Carbon::createFromFormat($dateFormatFromSetting, $date)->format('Y-m-d');
}

/*
 * Take: Time of setting format
 * Return: Time of database format
 * Dependency: helper function getTimeFormat()
 */
function databaseTimeFormatFromSetting($time)
{
    if (!$time) {
        return;
    }
    $timeFormatFromSetting = getTimeFormat();
    return Carbon::createFromFormat($timeFormatFromSetting, $time)->format('H:i');
}

/*
 * Take: DateTime of setting format
 * Return: DateTime of database format
 * Dependency: helper function getTimeFormat()
 * Dependency: helper function getTimeFormat()
 */
function databaseDateTimeObjectFromSetting($dateTime)
{
    if (!$dateTime) {
        return;
    }

    $dateFormatFromSetting = getDateFormat();
    $timeFormatFromSetting = getTimeFormat();
    $dateTimeFormatFromSetting = $dateFormatFromSetting . ' ' . $timeFormatFromSetting;
    return Carbon::createFromFormat($dateTimeFormatFromSetting, $dateTime);
}


