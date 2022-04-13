<?php

namespace App\Models;

use Google_Client;
use Google_Service_Calendar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Holiday extends Model
{
    use SoftDeletes;

    protected $guarded = [];


}
