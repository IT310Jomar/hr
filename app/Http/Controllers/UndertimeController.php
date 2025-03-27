<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\UndertimeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UndertimeController extends Controller
{
    public function requestUndertime()
    {
        $requestUndertime = UndertimeRequest::latest()->where('status_id','=','Pending')
        ->with([
            'employee' => function ($q){
                $q->select('*');
            }
        ])
        ->get();
        return response()->json(['success' => true, 'requestUndertime' => $requestUndertime]);
    }//requestUndertime()

    public function requestUndertimeApproved(){
        $requestUndertimeApproved = UndertimeRequest::latest()->where('status_id','=','Approved')->get();
        return response()->json(['success' => true, 'requestUndertimeApproved' => $requestUndertimeApproved]);
    }//requestUndertimeApproved()

    public function requestUndertimeDeclined(){
        $requestUndertimeDeclined = UndertimeRequest::latest()->where('status_id','=','Declined')->get();
        return response()->json(['success' => true, 'requestUndertimeDeclined' => $requestUndertimeDeclined]);
    }//requestUndertimeDeclined()

    public function searchrequestPending(){
        $searchrequestPending = request('query');

        $requestUndertime = UndertimeRequest::where(function ($query) use ($searchrequestPending) {
            $query->where('date_req', 'like', "%{$searchrequestPending}%")
                ->orWhere('from', 'like', "%{$searchrequestPending}%")
                ->orWhere('to', 'like', "%{$searchrequestPending}%")
                ->orWhere('total_hours', 'like', "%{$searchrequestPending}%")
                ->orWhere('reason', 'like', "%{$searchrequestPending}%");
        })->where('status_id', '=', 'Pending')->get();
        return response()->json(['success' => true, 'requestUndertime' => $requestUndertime]);
    }//searchrequestPending()

    public function searchrequestApproved(){
        $searchrequestApproved = request('query');

        $requestUndertimeApproved = UndertimeRequest::where(function ($query) use ($searchrequestApproved) {
            $query->where('date_req', 'like', "%{$searchrequestApproved}%")
                ->orWhere('from', 'like', "%{$searchrequestApproved}%")
                ->orWhere('to', 'like', "%{$searchrequestApproved}%")
                ->orWhere('total_hours', 'like', "%{$searchrequestApproved}%")
                ->orWhere('reason', 'like', "%{$searchrequestApproved}%");
        })->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'requestUndertimeApproved' => $requestUndertimeApproved]);
    }//searchrequestApproved()

    public function searchrequestDeclined(){
        $searchrequestDeclined = request('query');

        $requestUndertimeDeclined = UndertimeRequest::where(function ($query) use ($searchrequestDeclined) {
            $query->where('date_req', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('from', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('to', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('total_hours', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('reason', 'like', "%{$searchrequestDeclined}%");
        })->where('status_id', '=', 'Declined')->get();

        return response()->json(['success' => true, 'requestUndertimeDeclined' => $requestUndertimeDeclined]);
    }//searchrequestDeclined()

    public function store()
    {
        request()->validate([
            'date_req' => 'required',
            'from' => 'required',
            'to' => 'required',
            'total_hours' => 'required',
            'reason' => 'required',
        ]);

     $UndertimeRequest = UndertimeRequest::create([
            'user_id' => request('user_id'),
            'employee_id' => request('employee_id'),
            'date_req' => request('date_req'),
            'from' => request('from'),
            'to' => request('to'),
            'total_hours' => request('total_hours'),
            'reason' => request('reason'),
        ]);
        return response()->json(['success' => true, 'UndertimeRequest' => $UndertimeRequest]);
    }//store()

    public function view($id)
    {
        $viewUndertimeRequest =UndertimeRequest::find($id);
        return response()->json(['success' => true, 'viewUndertimeRequest' => $viewUndertimeRequest]);
    }//view()

    public function updateUndertimeRequest(UndertimeRequest $undertimeRequest)
    {
        request()->validate([
            'date_req' => 'required',
            'from' => 'required',
            'to' => 'required',
            'total_hours' => 'required',
            'reason' => 'required',
        ]);
        $undertimeRequest->update([
            'date_req' => request('date_req'),
            'from' => request('from'),
            'to' => request('to'),
            'total_hours' => request('total_hours'),
            'reason' => request('reason'),
        ]);
        return response()->json(['success' => true, 'undertimeRequest' => $undertimeRequest]);
    }//updateUndertimeRequest()

    public function fetchID($id)
    {
        $fetchID = UndertimeRequest::findOrFail($id);
        return response()->json(['success' => true, 'fetchID' => $fetchID]);
    }//fetchID()

    public function approveScheduleRequest(Request $fetchdata,$id)
    {
        $status = 'Approved';
        $fetchdata = UndertimeRequest::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata]);
    }//approveScheduleRequest()

    public function declineScheduleRequest(Request $fetchdata,$id)
    {
        $status = 'Declined';
        $fetchdata = UndertimeRequest::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata]);
    }//declineScheduleRequest9

    public function getData()
    {
        $user = Auth::user();
        $undertimeRequest = Employee::where('user_id', $user->id)->with([
           'undertime_requests' => function ($q){
            $q->select('*');
           } 
        ])->latest()->get();
        return response()->json(['success' => true, 'undertimeRequest' => $undertimeRequest],200);
    }
}
