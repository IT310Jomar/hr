<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveCredit;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {

        $leave_user = LeaveRequest::latest()->get();
        return response()->json(['success' => true, 'leave_user' => $leave_user], 200);
    } //index()

    public function requestLeave()
    {
        $requestLeave = LeaveRequest::latest()->where('status_id', '=', 'Pending')
            ->with([
                'employee' => function ($q) {
                    $q->select('*');
                }
            ])
            ->get();
        return response()->json(['sucess' => true, 'requestLeave' => $requestLeave], 200);
    } //requestLeave()

    public function requestLeaveApproved()
    {
        $requestLeaveApproved = LeaveRequest::latest()->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'requestLeaveApproved' => $requestLeaveApproved], 200);
    } //requestLeaveApproved()

    public function requestLeaveDeclined()
    {
        $requestLeaveDeclined = LeaveRequest::latest()->where('status_id', '=', 'Declined')->get();
        return response()->json(['success' => true, 'requestLeaveDeclined' => $requestLeaveDeclined], 200);
    } //requestLeaveDeclined

    public function searchrequestPending()
    {
        $searchRequestPending = request('query');

        $requestLeave = LeaveRequest::where(function ($query) use ($searchRequestPending) {
            $query->where('leave_type', 'like', "%{$searchRequestPending}%")
                ->orWhere('date_from', 'like', "%{$searchRequestPending}%")
                ->orWhere('date_to', 'like', "%{$searchRequestPending}%")
                ->orWhere('reason', 'like', "%{$searchRequestPending}%");
        })->where('status_id', '=', 'Pending')->get();
        return response()->json(['success' => true, 'requestLeave' => $requestLeave], 200);
    } //searchrequestPending()

    public function searchrequestApproved()
    {
        $searchrequestApproved = request('query');

        $requestLeaveApproved = LeaveRequest::where(function ($query) use ($searchrequestApproved) {
            $query->where('leave_type', 'like', "%{$searchrequestApproved}%")
                ->orWhere('date_from', 'like', "%{$searchrequestApproved}%")
                ->orWhere('date_to', 'like', "%{$searchrequestApproved}%")
                ->orWhere('reason', 'like', "%{$searchrequestApproved}%");
        })->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'requestLeaveApproved' => $requestLeaveApproved], 200);
    } //searchrequestApproved()

    public function searchrequestDeclined()
    {
        $searchrequestDeclined = request('query');

        $requestLeaveDeclined = LeaveRequest::where(function ($query) use ($searchrequestDeclined) {
            $query->where('leave_type', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('date_from', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('date_to', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('reason', 'like', "%{$searchrequestDeclined}%");
        })->where('status_id', '=', 'Declined')->get();

        return response()->json(['success' => true, 'requestLeaveDeclined' => $requestLeaveDeclined], 200);
    } //searchrequestDeclined()

    public function store(Request $request)
    {
        request()->validate([
            'leave_type' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'reason' => 'required',
            'file_attachment' => 'required|max:5000',
        ]);
        if ($request->file('file_attachment')) {
            $file =  $request->file('file_attachment');
            $file_name = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('File_Upload'), $file_name);
        }
        $leaveRequest = LeaveRequest::create([
            'user_id' => request('user_id'),
            'employee_id' => request('employee_id'),
            'leave_type' => request('leave_type'),
            'date_from' => request('date_from'),
            'date_to' => request('date_to'),
            'reason' => request('reason'),
            'file_attachment' => env('APP_URL') . 'File_Upload/' . $file_name
        ]);

        return response()->json(['success' => true, 'leaveRequest' => $leaveRequest,], 200);
    } //store()

    public function view($id)
    {
        $viewLeaveRequest = LeaveRequest::find($id);
        return response()->json(['success' => true, 'viewLeaveRequest' => $viewLeaveRequest], 200);
    } //view()

    public function updateLeaveRequest(LeaveRequest $leaveRequest)
    {
        request()->validate([
            'leave_type' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'reason' => 'required',
        ]);
        $leaveRequest->update([
            'leave_type' => request('leave_type'),
            'date_from' => request('date_from'),
            'date_to' => request('date_to'),
            'reason' => request('reason'),
        ]);
        return response()->json(['success' => true, 'leaveRequest' => $leaveRequest], 200);
    } //updateLeaveRequest()

    public function fetchID($id)
    {
        $fetchID = LeaveRequest::findOrFail($id);
        return response()->json(['success' => true, 'leaveRequest' => $fetchID], 200);
    } //fetchID()

    public function approveLeaveRequest(Request $fetchdata, $id)
    {
        $status = 'Approved';
        $fetchdata = LeaveRequest::findOrFail($id);
        $employee = $fetchdata->employee_id;
        // dd($employee);

        $datefrom = Carbon::parse($fetchdata->date_from);
        $dateto = Carbon::parse($fetchdata->date_to);
        $daysDifference = $dateto->diffInDays($datefrom);

        if ($fetchdata->leave_type == 'Sick') {
            $leave_credits = LeaveCredit::where('employee_id', $employee)->first();

            if ($leave_credits) {
                $sick_credit = $leave_credits->sick_leave_credits - $daysDifference;
                $leave_credits->sick_leave_credits = $sick_credit;
                $leave_credits->save();
            }

            $fetchdata->update([
                'status_id' => $status,
            ]);
        } else if ($fetchdata->leave_type == 'Vacation') {
            $leave_credits = LeaveCredit::where('employee_id', $employee)->first();

            if ($leave_credits) {
                $vacation_credit = $leave_credits->vacation_leave_credits - $daysDifference;
                $leave_credits->vacation_leave_credits = $vacation_credit;
                $leave_credits->save();
            }

            $fetchdata->update([
                'status_id' => $status,
            ]);
        }
        return response()->json(['success' => 'vacation'], 200);
    } //approveLeaveRequest()

    public function declineLeaveRequest(Request $fetchdata, $id)
    {
        $status = 'Declined';
        $fetchdata = LeaveRequest::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata], 200);
    } //declineLeaveRequest()

    public function getData()
    {
        $user = Auth::user();
        $leaveRequest = Employee::where('user_id', $user->id)->with([
            'leave_requests' => function ($q) {
                $q->select('*');
            }
        ])->with([
            'leave_credits' => function ($q) {
                $q->select('*');
            }
        ])->latest()->get();
        return response()->json(['success' => true, 'leaveRequest' => $leaveRequest], 200);
    } // public function getData()

}
