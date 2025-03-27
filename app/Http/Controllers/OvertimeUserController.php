<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OvertimeUser;
use App\Http\Controllers\Controller;

class OvertimeUserController extends Controller
{
    public function index() {
        
        $overtime_user = OvertimeUser::latest()->get();

        return response()->json($overtime_user);
    }
}
