<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UndertimeUser;
use App\Http\Controllers\Controller;

class UndertimeUserController extends Controller
{
    public function index() {
        
        $undertime_user = UndertimeUser::latest()->get();

        return response()->json($undertime_user);
    }
}
