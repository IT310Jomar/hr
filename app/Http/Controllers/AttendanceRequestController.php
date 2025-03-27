<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceRequestController extends Controller
{
    public function requestAttendance()
    {
        $requestAttendance = Attendance::latest()->where('status_id', '=', 'Pending')->get();
        return response()->json(['success' => true, 'requestAttendance' => $requestAttendance]);
    } //requestAttendance()

    public function requestAttendanceApproved()
    {
        $requestAttendanceApproved = Attendance::latest()->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'requestAttendanceApproved' => $requestAttendanceApproved]);
    } //requestAttendanceApproved()

    public function requestAttendanceDeclined()
    {
        $requestAttendanceDeclined = Attendance::latest()->where('status_id', '=', 'Declined')->get();
        return response()->json(['success' => true, 'requestAttendanceDeclined' => $requestAttendanceDeclined]);
    } //requestAttendanceDeclined()

    public function searchrequestPending()
    {
        $searchRequestPending = request('query');

        $requestAttendance = Attendance::where(function ($query) use ($searchRequestPending) {
            $query->where('created_at', 'like', "%{$searchRequestPending}%")
                ->orWhere('timeIn', 'like', "%{$searchRequestPending}%")
                ->orWhere('state', 'like', "%{$searchRequestPending}%")
                ->orWhere('type', 'like', "%{$searchRequestPending}%")
                ->orWhere('remarks', 'like', "%{$searchRequestPending}%");
        })->where('status_id', '=', 'Pending')->get();
        return response()->json(['success' => true, 'requestAttendance' => $requestAttendance], 200);
    } //searchrequestPending()

    public function searchrequestApproved()
    {
        $searchrequestApproved = request('query');

        $requestAttendanceApproved = Attendance::where(function ($query) use ($searchrequestApproved) {
            $query->where('created_at', 'like', "%{$searchrequestApproved}%")
                ->orWhere('timeIn', 'like', "%{$searchrequestApproved}%")
                ->orWhere('state', 'like', "%{$searchrequestApproved}%")
                ->orWhere('type', 'like', "%{$searchrequestApproved}%")
                ->orWhere('remarks', 'like', "%{$searchrequestApproved}%");
        })->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'requestAttendanceApproved' => $requestAttendanceApproved], 200);
    } //searchrequestApproved()

    public function searchrequestDeclined()
    {
        $searchrequestDeclined = request('query');

        $requestAttendanceDeclined = Attendance::where(function ($query) use ($searchrequestDeclined) {
            $query->where('created_at', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('timeIn', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('state', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('type', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('remarks', 'like', "%{$searchrequestDeclined}%");
        })->where('status_id', '=', 'Declined')->get();

        return response()->json(['success' => true, 'requestAttendanceDeclined' => $requestAttendanceDeclined], 200);
    } //searchrequestDeclined()

    public function store(Request $request)
    {
        $attendance = $request->input('attendance');
        $id = request('attendanceId');
        $state = [];
        $date = [];
        $time = [];
        $count = count($attendance);

        foreach ($attendance as $row) {
            $state[] = $row['state'];
            $date[] = $row['attendance_date'];
            $time[] = $row['attendance_time'];
        }

        if ($count === 1) {
            $existingRecord = Attendance::where('id', $id)->where('login', $date[0])->where('status_id', 'Pending')->first();
            if ($state[0] === 'Check In') {
                if (!$existingRecord) {
                    // Create new record
                    $newRecord = Attendance::create([
                        'user_id' => request('user_id'),
                        'employee_id' => request('employee_id'),
                        'login' => $date[0],
                        'timeIn' => $time[0],
                        'state' => $state[0],
                        'type' => request('type'),
                        'remarks' => request('remarks')
                    ]);
                    return response()->json(['success' => true], 200);
                } else {
                    $errorMessage = "An existing record already exists.";
                    return response()->json(['error1' => $errorMessage]);
                }
            } else {
                if ($existingRecord) {
                    // Update existing record
                    $existingRecord->state = $state[0];
                    $existingRecord->logout = $date[0];
                    $existingRecord->timeOut = $time[0];
                    $existingRecord->type = request('type');
                    $existingRecord->remarks = request('remarks');
                    $existingRecord->save();
                    return response()->json(['success' => true], 200);
                } else {
                    $errorMessage = "You need to request check in first.";
                    return response()->json(['error2' => $errorMessage]);
                }
            }
        } else {
            if ($state[0] === 'Check In' && $state[1] === 'Check Out') {
                $existingRecord = Attendance::where('id', $id)->where('login', $date[0])->where('status_id', 'Pending')->first();
                if ($date[0] === $date[1]) {
                    if (!$existingRecord) {
                        // Create new record
                        $newRecord = Attendance::create([
                            'user_id' => request('user_id'),
                            'employee_id' => request('employee_id'),
                            'login' => $date[0],
                            'timeIn' => $time[0],
                            'logout' => $date[1],
                            'timeOut' => $time[1],
                            'state' => $state[1],
                            'type' => request('type'),
                            'remarks' => request('remarks')
                        ]);
                        return response()->json(['success' => true], 200);
                    } else {
                        $errorMessage = "An existing record already exists.";
                        return response()->json(['error1' => $errorMessage]);
                    }
                } else {
                    $errorMessage = "The date should be the same.";
                    return response()->json(['error3' => $errorMessage]);
                }
            } else if ($state[0] === 'Check Out' && $state[1] === 'Check In') {
                $existingRecord = Attendance::where('id', $id)->where('login', $date[1])->where('status_id', 'Pending')->first();
                if ($date[0] === $date[1]) {
                    if (!$existingRecord) {
                        // Create new record
                        $newRecord = Attendance::create([
                            'user_id' => request('user_id'),
                            'employee_id' => request('employee_id'),
                            'login' => $date[1],
                            'timeIn' => $time[1],
                            'logout' => $date[0],
                            'timeOut' => $time[0],
                            'state' => $state[0],
                            'type' => request('type'),
                            'remarks' => request('remarks')
                        ]);
                        return response()->json(['success' => true], 200);
                    } else {
                        $errorMessage = "An existing record already exists.";
                        return response()->json(['error1' => $errorMessage]);
                    }
                } else {
                    $errorMessage = "The date should be the same.";
                    return response()->json(['error3' => $errorMessage]);
                }
            }else{
                $errorMessage = "It should be in and out.";
                return response()->json(['error4' => $errorMessage]);
            }
        }
    } //store()

    public function view($id)
    {
        $viewAttendanceRequest = Attendance::find($id);
        return response()->json(['success' => true, 'viewAttendanceRequest' => $viewAttendanceRequest], 200);
    } //view()

    public function updateAttendanceRequest(Attendance $attendancereq)
    {
        request()->validate([
            'timeIn' => 'required',
            'type' => 'required',
            'remarks' => 'required',
        ]);
        $attendancereq->update([
            'timeIn' => request('timeIn'),
            'type' => request('type'),
            'remarks' => request('remarks'),
        ]);
        return response()->json(['success' => true, 'attendancereq' => $attendancereq], 200);
    } //updateAttendanceRequest()

    public function getData()
    {
        $user = Auth::user();
        $attendanceData = Employee::where('user_id', $user->id)->with([
            'attendance_logs' => function ($q) {
                $q->select('*');
            }
        ])->latest()->get();
        return response()->json(['success' => true, 'attendanceData' => $attendanceData], 200);
    }

    public function approveAttendanceRequest(Request $fetchdata, $id)
    {
        $status = 'Approved';
        $attendance = Attendance::findOrFail($id);
        $attendance->status_id = $status;
        $attendance->save();
        return response()->json(['success' => true, 'attendance' => $attendance], 200);
    } //approveAttendanceRequest()

    public function declineAttendanceRequest(Request $fetchdata, $id)
    {
        $status = 'Declined';
        $attendance = Attendance::findOrFail($id);
        $attendance->status_id = $status;
        $attendance->save();
        return response()->json(['success' => true, 'attendance' => $attendance], 200);
    } //declineAttendanceRequest()
}
