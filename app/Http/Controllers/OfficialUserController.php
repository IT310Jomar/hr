<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfficialUser;
use App\Http\Controllers\Controller;

class OfficialUserController extends Controller
{
    public function index() {
        
        $official_user = OfficialUser::latest()->get();

        return response()->json($official_user);
    }
}
