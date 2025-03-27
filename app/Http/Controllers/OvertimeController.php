<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OvertimeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    public function index()
    {

        $overtime = OvertimeRequest::latest()->get();
        return response()->json(['success' => true, 'leave_user' => $overtime], 200);
    } //index()

    public function requesOvertimePending()
    {
        $requesOvertimePending = OvertimeRequest::latest()->where('status_id', '=', 'Pending')
        ->with([
            'employee' => function ($q){
                $q->select('*');
            }
        ])
        ->get();
        return response()->json(['sucess' => true, 'requesOvertimePending' => $requesOvertimePending], 200);
    } //requesOvertimePending()

    public function requestOvertimeApproved()
    {
        $requestOvertimeApproved = OvertimeRequest::latest()->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'requestOvertimeApproved' => $requestOvertimeApproved], 200);
    } //requestOvertimeApproved()

    public function requestOvertimeDeclined()
    {
        $requestOvertimeDeclined = OvertimeRequest::latest()->where('status_id', '=', 'Declined')->get();
        return response()->json(['success' => true, 'requestOvertimeDeclined' => $requestOvertimeDeclined], 200);
    } //requestOvertimeDeclined

    public function searchrequestPending()
    {
        $searchRequestPending = request('query');

        $requesOvertimePending = OvertimeRequest::where(function ($query) use ($searchRequestPending) {
            $query->where('day', 'like', "%{$searchRequestPending}%")
                ->orWhere('shift_date', 'like', "%{$searchRequestPending}%")
                ->orWhere('shift_from', 'like', "%{$searchRequestPending}%")
                ->orWhere('shift_to', 'like', "%{$searchRequestPending}%")
                ->orWhere('classification', 'like', "%{$searchRequestPending}%")
                ->orWhere('start', 'like', "%{$searchRequestPending}%")
                ->orWhere('end', 'like', "%{$searchRequestPending}%")
                ->orWhere('purpose', 'like', "%{$searchRequestPending}%");
        })->where('status_id', '=', 'Pending')->get();
        return response()->json(['success' => true, 'requesOvertimePending' => $requesOvertimePending], 200);
    } //searchrequestPending()

    public function searchrequestApproved()
    {
        $searchrequestApproved = request('query');

        $requestOvertimeApproved = OvertimeRequest::where(function ($query) use ($searchrequestApproved) {
            $query->where('day', 'like', "%{$searchrequestApproved}%")
                ->orWhere('shift_date', 'like', "%{$searchrequestApproved}%")
                ->orWhere('shift_from', 'like', "%{$searchrequestApproved}%")
                ->orWhere('shift_to', 'like', "%{$searchrequestApproved}%")
                ->orWhere('classification', 'like', "%{$searchrequestApproved}%")
                ->orWhere('start', 'like', "%{$searchrequestApproved}%")
                ->orWhere('end', 'like', "%{$searchrequestApproved}%")
                ->orWhere('purpose', 'like', "%{$searchrequestApproved}%");
        })->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'requestOvertimeApproved' => $requestOvertimeApproved], 200);
    } //searchrequestApproved()

    public function searchrequestDeclined()
    {
        $searchrequestDeclined = request('query');
        $requestOvertimeDeclined = OvertimeRequest::where(function ($query) use ($searchrequestDeclined) {
            $query->where('day', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('shift_date', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('shift_from', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('shift_to', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('classification', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('start', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('end', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('purpose', 'like', "%{$searchrequestDeclined}%");
        })->where('status_id', '=', 'Declined')->get();

        return response()->json(['success' => true, 'requestOvertimeDeclined' => $requestOvertimeDeclined], 200);
    } //searchrequestDeclined()

    public function store()
    {
        request()->validate([
            'day' => 'required',
            'shift_date' => 'required',
            'shift_from' => 'required',
            'shift_to' => 'required',
            'classification' => 'required',
            'start' => 'required',
            'end' => 'required',
            'purpose' => 'required'

        ]);
        $overtimeRequest = OvertimeRequest::create([
            'user_id' => request('user_id'),
            'employee_id' => request('employee_id'),
            'day' => request('day'),
            'shift_date' => request('shift_date'),
            'shift_from' => request('shift_from'),
            'shift_to' => request('shift_to'),
            'classification' => request('classification'),
            'start' => request('start'),
            'end' => request('end'),
            'purpose' => request('purpose')

        ]);
        return response()->json(['success' => true, 'overtimeRequest' => $overtimeRequest], 200);
    } //store()

    public function view($id)
    {
        $viewOvertimeRequest = OvertimeRequest::find($id);
        return response()->json(['success' => true, 'viewOvertimeRequest' => $viewOvertimeRequest], 200);
    } //view()

    public function updateOvertimeRequest(OvertimeRequest $overtimeRequest)
    {
        request()->validate([
            'day' => 'required',
            'shift_date' => 'required',
            'shift_from' => 'required',
            'shift_to' => 'required',
            'classification' => 'required',
            'start' => 'required',
            'end' => 'required',
            'purpose' => 'required'
        ]);
        $overtimeRequest->update([
            'day' => request('day'),
            'shift_date' => request('shift_date'),
            'shift_from' => request('shift_from'),
            'shift_to' => request('shift_to'),
            'classification' => request('classification'),
            'start' => request('start'),
            'end' => request('end'),
            'purpose' => request('classification')
        ]);
        return response()->json(['success' => true, 'overtimeRequest' => $overtimeRequest], 200);
    } //updateOvertimeRequest()

    public function fetchID($id)
    {
        $fetchID = OvertimeRequest::findOrFail($id);
        return response()->json(['success' => true, 'fetchID' => $fetchID], 200);
    } //fetchID()

    public function approveOvertimeRequest(Request $fetchdata, $id)
    {
        $status = 'Approved';
        $fetchdata = OvertimeRequest::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata], 200);
    } //approveLeaveRequest()

    public function declineOvertimeRequest(Request $fetchdata, $id)
    {
        $status = 'Declined';
        $fetchdata = OvertimeRequest::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata], 200);
    } //declineLeaveRequest()

    public function getData()
    {
        $user = Auth::user();
        $overtimeRequest = Employee::where('user_id', $user->id)->with([
            'overtime_requests' => function ($q) {
                $q->select('*');
            }
        ])->with([
            'schedule' => function ($q) {
                $q->select('*');
            }
        ])->latest()->get();
        return response()->json(['success' => true, 'overtimeRequest' => $overtimeRequest], 200);
    }
}
