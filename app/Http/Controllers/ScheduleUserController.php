<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleUser;
use App\Http\Controllers\Controller;

class ScheduleUserController extends Controller
{
    public function index() {
        
        $schedule_user = ScheduleUser::latest()->get();

        return response()->json($schedule_user);
    }
}
