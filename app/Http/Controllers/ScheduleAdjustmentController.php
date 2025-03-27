<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ScheduleAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleAdjustmentController extends Controller
{
    public function requestSchedule()
    {
        $requestSchedulePending = ScheduleAdjustment::latest()->where('status_id','=','Pending')
        ->with([
            'employee' => function ($q){
                $q->select('*');
            }
        ])
        ->get();
        return response()->json(['success' => true, 'requestSchedulePending' => $requestSchedulePending],200);
    }//requestSchedule()

    public function requestScheduleApproved(){
        $requestScheduleApproved = ScheduleAdjustment::latest()->where('status_id','=','Approved')->get();
        return response()->json(['success' => true, 'requestScheduleApproved' => $requestScheduleApproved],200);
    }//requestScheduleApproved()
    
    public function requestScheduleDeclined(){
        $requestScheduleDeclined = ScheduleAdjustment::latest()->where('status_id','=','Declined')->get();
        return response()->json(['success' => true, 'requestScheduleDeclined' => $requestScheduleDeclined],200);
    }//requestScheduleDeclined()

    public function searchrequestPending(){
        $searchRequestPending = request('query');

        $requestSchedulePending = ScheduleAdjustment::where(function ($query) use ($searchRequestPending) {
            $query->where('date_from', 'like', "%{$searchRequestPending}%")
            ->orWhere('date_to', 'like', "%{$searchRequestPending}%")
            ->orWhere('shift_start', 'like', "%{$searchRequestPending}%")
            ->orWhere('shift_end', 'like', "%{$searchRequestPending}%")
            ->orWhere('break_start', 'like', "%{$searchRequestPending}%")
            ->orWhere('break_end', 'like', "%{$searchRequestPending}%");
    })->where('status_id', '=', 'Pending')->get();
        return response()->json(['success' => true, 'requestSchedulePending' => $requestSchedulePending], 200);
    }//searchrequestPending()

    public function searchrequestApproved(){
        $searchrequestApproved = request('query');

        $requestScheduleApproved = ScheduleAdjustment::where(function ($query) use ($searchrequestApproved) {
            $query->where('date_from', 'like', "%{$searchrequestApproved}%")
                ->orWhere('date_to', 'like', "%{$searchrequestApproved}%")
                ->orWhere('shift_start', 'like', "%{$searchrequestApproved}%")
                ->orWhere('shift_end', 'like', "%{$searchrequestApproved}%")
                ->orWhere('break_start', 'like', "%{$searchrequestApproved}%")
                ->orWhere('break_end', 'like', "%{$searchrequestApproved}%");
        })->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'requestScheduleApproved' => $requestScheduleApproved],200);
    }//searchrequestApproved()

    public function searchrequestDeclined(){
        $searchrequestDeclined = request('query');

        $requestScheduleDeclined = ScheduleAdjustment::where(function ($query) use ($searchrequestDeclined) {
            $query->where('date_from', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('date_to', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('shift_start', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('shift_end', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('break_start', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('break_end', 'like', "%{$searchrequestDeclined}%");
        })->where('status_id', '=', 'Declined')->get();

        return response()->json(['success' => true, 'requestScheduleDeclined' => $requestScheduleDeclined],200);
    }//searchrequestDeclined()

    public function store()
    {
        request()->validate([
            'date_from' => 'required',
            'date_to' => 'required',
            'shift_start' => 'required',
            'shift_end' => 'required',
            'break_start' => 'required',
            'break_end' => 'required',
        ]);
     $ScheduleRequest = ScheduleAdjustment::create([
            'user_id' => request('user_id'),
            'employee_id' => request('employee_id'),
            'date_from' => request('date_from'),
            'date_to' => request('date_to'),
            'shift_start' => request('shift_start'),
            'shift_end' => request('shift_end'),
            'break_start' => request('break_start'),
            'break_end' => request('break_end'),
        ]);
        return response()->json(['success' => true, 'ScheduleRequest' => $ScheduleRequest],200);
    }//store()

    public function view($id)
    {
        $viewScheduleRequest =ScheduleAdjustment::find($id);
        return response()->json(['success' => true, 'viewScheduleRequest' => $viewScheduleRequest],200);
    }//view()

    public function updateScheduleRequest(ScheduleAdjustment $scheduleRequest)
    {
        request()->validate([
            'date_from' => 'required',
            'date_to' => 'required',
            'shift_start' => 'required',
            'shift_end' => 'required',
            'break_start' => 'required',
            'break_end' => 'required',
        ]);
        $scheduleRequest->update([
            'date_from' => request('date_from'),
            'date_to' => request('date_to'),
            'shift_start' => request('shift_start'),
            'shift_end' => request('shift_end'),
            'break_start' => request('break_start'),
            'break_end' => request('break_end'),
        ]);
        return response()->json(['success' => true, 'scheduleRequest' => $scheduleRequest],200);
    }//updateScheduleRequest()

    public function fetchID($id)
    {
        $fetchID = ScheduleAdjustment::findOrFail($id);
        return response()->json(['success' => true, 'fetchID' => $fetchID],200);
    }//fetchID()

    public function approveScheduleRequest(Request $fetchdata,$id)
    {
        $status = 'Approved';
        $fetchdata = ScheduleAdjustment::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status

        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata],200);
    }//approveScheduleRequest()

    public function declineScheduleRequest(Request $fetchdata,$id)
    {
        $status = 'Declined';
        $fetchdata = ScheduleAdjustment::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status

        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata],200);
    }//declineScheduleRequest

    public function getData() 
    {
        $user = Auth::user();
        $scheduleAdjustment = Employee::where('user_id', $user->id)->with([
            'schedule_adjustments' => function ($q){
                $q->select('*');
            }
        ])->latest()->get();
        return response()->json(['success' => true, 'scheduleAdjustment' => $scheduleAdjustment],200);
    }
}
