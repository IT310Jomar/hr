<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\CashAdvance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CashAdvanceController extends Controller
{

    //Query the data based on their Status
    public function requestCashAdvance()
    {
        $cashAdvancePending = CashAdvance::latest()->where('request_status', '=', 'Pending')
        ->with([
            'employee' => function ($q){
                $q->select('*');
            }
        ])
        ->get();
        return response()->json(['success' => true, 'cashAdvancePending' => $cashAdvancePending], 200);
    } //public function requestCashAdvance()

    public function requestCashApproved()
    {
        $cashAdvanceApproved = CashAdvance::latest()->where('request_status', '=', 'Approved')
        ->with([
            'employee' => function ($q){
                $q->select('*');
            }
        ])
        ->get();
        return response()->json(['success' => true, 'cashAdvanceApproved' => $cashAdvanceApproved], 200);
    } // public function requestCashApproved()

    public function requestCashDeclined()
    {
        $cashAdvanceDeclined = CashAdvance::latest()->where('request_status', '=', 'Declined')->get();
        return response()->json(['success' => true, 'cashAdvanceDeclined' => $cashAdvanceDeclined], 200);
    } //public function requestCashDeclined()

    public function searchrequestPending()
    {
        $searchrequestPending = request('query');

        $cashAdvancePending = CashAdvance::where(function ($query) use ($searchrequestPending) {
            $query->where('requested_date', 'like', "%{$searchrequestPending}%")
                ->orWhere('amount', 'like', "%{$searchrequestPending}%")
                ->orWhere('reasons', 'like', "%{$searchrequestPending}%");
        })->where('request_status', '=', 'Pending')->get();
        return response()->json(['success' => true, 'cashAdvancePending' =>  $cashAdvancePending], 200);
    } //public function searchrequestPending()

    public function searchrequestApproved()
    {
        $searchrequestApproved = request('query');

        $cashAdvanceApproved = CashAdvance::where(function ($query) use ($searchrequestApproved) {
            $query->where('requested_date', 'like', "%{$searchrequestApproved}%")
                ->orWhere('date_approved', 'like', "%{$searchrequestApproved}%")
                ->orWhere('amount', 'like', "%{$searchrequestApproved}%")
                ->orWhere('reasons', 'like', "%{$searchrequestApproved}%");
        })->where('request_status', '=', 'Approved')->get();
        return response()->json(['success' => true, 'cashAdvanceApproved' => $cashAdvanceApproved], 200);
    } // public function searchrequestApproved()

    public function searchrequestDeclined()
    {
        $searchrequestDeclined = request('query');

        $cashAdvanceDeclined = CashAdvance::where(function ($query) use ($searchrequestDeclined) {
            $query->where('requested_date', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('date_decline', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('amount', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('reasons', 'like', "%{$searchrequestDeclined}%");
        })->where('request_status', '=', 'Declined')->get();
        return response()->json(['success' => true, 'cashAdvanceDeclined' => $cashAdvanceDeclined], 200);
    } //public function searchrequestDeclined()

    public function view($id)
    {
        $viewCashAdvance = CashAdvance::find($id);
        return response()->json(['success' => true, 'viewCashAdvance' => $viewCashAdvance], 200);
    } // public function view

    public function updateRequest(CashAdvance $cashAdvance)
    {
        request()->validate([
            'requested_date' => 'required',
            'amount' => 'required',
            'reasons' => 'required',

        ]);
        $cashAdvance->update([
            'requested_date' => request('requested_date'),
            'amount' => request('amount'),
            'reasons' => request('reasons'),
        ]);

        return response()->json(['success' => true, 'cashAdvance' => $cashAdvance], 200);
    } //public function updateRequest

    public function fetchID($id)
    {
        $fetchID = CashAdvance::findOrFail($id);
        return response()->json(['success' => true, 'fetchID' => $fetchID], 200);
    } // public function fetchID

    public function approveRequest(Request $fetchdata, $id)
    {
        $status = 'Approved';
        $fetchdata = CashAdvance::findOrFail($id);
        $fetchdata->update([
            'request_status' => $status,
            'date_approved' => Carbon::now()
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata], 200);
    } //public function approveRequest

    public function declinedRequest(Request $fetchdata, $id)
    {
        $status = 'Declined';
        $fetchdata = CashAdvance::findOrFail($id);
        $fetchdata->update([
            'request_status' => $status,
            'date_decline' => Carbon::now()
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata], 200);
    } //public function declinedRequest

    public function store()
    {
        request()->validate([
            'requested_date' => 'required',
            'amount' => 'required',
            'reasons' => 'required',
        ]);

        $cashAdvance = CashAdvance::create([
            'user_id' => request('user_id'),
            'employee_id' => request('employee_id'),
            'requested_date' => request('requested_date'),
            'amount' => request('amount'),
            'reasons' => request('reasons'),
        ]);

        return response()->json(['success' => true, 'cashAdvance' => $cashAdvance], 200);
    } // public function store

    public function getData()
    {
        $user = Auth::user();
        $cashAdvance = Employee::where('user_id', $user->id)->with([
            'cash_advances' => function ($q) {
                $q->select('*');
            }
        ])->latest()->get();
        return response()->json(['success' => true, 'cashAdvance' => $cashAdvance], 200);
    } // public function getData()
}
