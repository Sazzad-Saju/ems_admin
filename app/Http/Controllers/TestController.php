<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {

        $data = Attendance::first();

    }
}
