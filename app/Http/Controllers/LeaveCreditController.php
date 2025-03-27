<?php

namespace App\Http\Controllers;

use App\Models\LeaveCredit;
use Illuminate\Http\Request;

class LeaveCreditController extends Controller
{
        public function leave(){
            $leaveCount = LeaveCredit::all();
            return response()->json(['success' => true, 'leaveCount' => $leaveCount],200);
        }

        public function leaveUpdate(Request $request, LeaveCredit $leavecredit){
            if ($request->has('sick_leave_credits')) {
                $leavecredit->update([
                    'sick_leave_credits' => $request->input('sick_leave_credits')
                ]);
            }
            if ($request->has('vacation_leave_credits')) {
                $leavecredit->update([
                    'vacation_leave_credits' => $request->input('vacation_leave_credits')
                ]);
            }
            return response()->json(['success' => true, 'leavecredit' => $leavecredit]);
        }
        
}
