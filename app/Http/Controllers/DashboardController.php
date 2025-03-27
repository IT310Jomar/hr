<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\CashAdvance;
use App\Models\Employments;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Models\IncidentReport;
use App\Models\OvertimeRequest;
use App\Models\UndertimeRequest;
use App\Models\ScheduleAdjustment;
use App\Models\OfficialBusinessRequest;

class DashboardController extends Controller
{
    public function getAllPending()
    {
        $cashAdvancePending = CashAdvance::where('request_status', '=', 'Pending')->get();
        $leavePending = LeaveRequest::where('status_id', '=', 'Pending')->get();
        $attendancePening = Attendance::where('status_id', '=', 'Pending')->get();
        $schedulePending = ScheduleAdjustment::where('status_id', '=', 'Pending')->get();
        $overtimePending = OvertimeRequest::where('status_id', '=', 'Pending')->get();
        $undertimePedning = UndertimeRequest::where('status_id', '=', 'Pending')->get();
        $businessRequest = OfficialBusinessRequest::where('status_id', '=', 'Pending')->get();

        return response()->json([
            'success'                   =>          true,
            'cashAdvancePending'        =>          $cashAdvancePending,
            'leavePending'              =>          $leavePending,
            'attendancePening'          =>          $attendancePening,
            'schedulePending'           =>          $schedulePending,
            'overtimePending'           =>          $overtimePending,
            'undertimePedning'          =>          $undertimePedning,
            'businessRequest'           =>          $businessRequest
        ]);
    }

    public function getIncident()
    {
        $incident = IncidentReport::get();
        return response()->json([
            'success'       =>      true,
            'incident'      =>      $incident
        ]);
    }
    public function headCount()
    {
        $regularOrProbationary= Employments::whereIn('status_id', [1, 8])->count();
       
    
        return response()->json(['success' => true, 'counts' =>  $regularOrProbationary], 200);
    }
    public function countContigents(){
        $contingents = Employments::whereIn('status_id', [5,6,7,9,10,11,12,13])->count();
        $onLeave = Employments::whereIn('status_id', [2,3,4])->count();
        return response()->json(['success' => true,  'conti' =>  $contingents,'onLeave' => $onLeave], 200);
    }
    

}
