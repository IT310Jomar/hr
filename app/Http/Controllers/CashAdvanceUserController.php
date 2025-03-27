<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashAdvanceUser;
use App\Http\Controllers\Controller;

class CashAdvanceUserController extends Controller
{
    public function index() {
        
        $cashadvance_user = CashAdvanceUser::latest()->get();

        return response()->json($cashadvance_user);
    }
    
}
