<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OfficialBusinessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficialBusinessController extends Controller
{
    public function businessRequest()
    {
        $businessRequest = OfficialBusinessRequest::latest()->where('status_id','=','Pending')
        ->with([
            'employee' => function ($q){
                $q->select('*');
            }
        ])
        ->get();
        return response()->json(['success' => true, 'businessRequest' => $businessRequest],200);
    }//businessRequest()

    public function businessRequestApproved(){
        $businessRequestApproved = OfficialBusinessRequest::latest()->where('status_id','=','Approved')->get();
        return response()->json(['success' => true, 'businessRequestApproved' => $businessRequestApproved],200);
    }//businessRequestApproved()

    public function businessRequestDeclined(){
        $businessRequestDeclined = OfficialBusinessRequest::latest()->where('status_id','=','Declined')->get();
        return response()->json(['success' => true, 'businessRequestDeclined' => $businessRequestDeclined],200);
    }//businessRequestDeclined()

    public function searchrequestPending(){
        $searchrequestPending = request('query');

        $businessRequest = OfficialBusinessRequest::where(function ($query) use ($searchrequestPending) {
            $query->where('date_from', 'like', "%{$searchrequestPending}%")
                ->orWhere('date_to', 'like', "%{$searchrequestPending}%")
                ->orWhere('time_from', 'like', "%{$searchrequestPending}%")
                ->orWhere('time_to', 'like', "%{$searchrequestPending}%")
                ->orWhere('location', 'like', "%{$searchrequestPending}%")
                ->orWhere('purpose', 'like', "%{$searchrequestPending}%");
        })->where('status_id', '=', 'Pending')->get();
        return response()->json(['success' => true, 'businessRequest' => $businessRequest],200);
    }//searchrequestPending()

    public function searchrequestApproved(){
        $searchrequestApproved = request('query');

        $businessRequestApproved = OfficialBusinessRequest::where(function ($query) use ($searchrequestApproved) {
            $query->where('date_from', 'like', "%{$searchrequestApproved}%")
                ->orWhere('date_to', 'like', "%{$searchrequestApproved}%")
                ->orWhere('time_from', 'like', "%{$searchrequestApproved}%")
                ->orWhere('time_to', 'like', "%{$searchrequestApproved}%")
                ->orWhere('location', 'like', "%{$searchrequestApproved}%")
                ->orWhere('purpose', 'like', "%{$searchrequestApproved}%");
        })->where('status_id', '=', 'Approved')->get();
        return response()->json(['success' => true, 'businessRequestApproved' => $businessRequestApproved],200);
    }//searchrequestApproved()

    public function searchrequestDeclined(){
        $searchrequestDeclined = request('query');

        $businessRequestDeclined = OfficialBusinessRequest::where(function ($query) use ($searchrequestDeclined) {
            $query->where('date_from', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('date_to', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('time_from', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('time_to', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('location', 'like', "%{$searchrequestDeclined}%")
                ->orWhere('purpose', 'like', "%{$searchrequestDeclined}%");
        })->where('status_id', '=', 'Declined')->get();

        return response()->json(['success' => true, 'businessRequestDeclined' => $businessRequestDeclined],200);
    }//searchrequestDeclined()

    public function store()
    {
        request()->validate([
            'date_from'=>'required',
            'date_to'=>'required',
            'time_from'=>'required',
            'time_to'=>'required',
            'location'=>'required',
            'purpose'=>'required',

        ]);

        $getBusinessRequest = OfficialBusinessRequest::create([ 
            'user_id' => request('user_id'),
            'employee_id' => request('employee_id'),
            'date_from' => request('date_from'),
            'date_to' => request('date_to'),
            'time_from' => request('time_from'),
            'time_to' => request('time_to'),
            'location' => request('location'),
            'purpose' => request('purpose'),
        ]);
        return response()->json(['success' => true, 'getBusinessRequest' => $getBusinessRequest],200);
    }//store()

    public function view($id)
    {
        $viewBusinessRequest = OfficialBusinessRequest::find($id);
        return response()->json($viewBusinessRequest);
    }

    public function updateBusinessRequest(OfficialBusinessRequest $businessRequest)
    {
        request()->validate([
            'date_from'=>'required',
            'date_to'=>'required',
            'time_from'=>'required',
            'time_to'=>'required',
            'location'=>'required',
            'purpose'=>'required',

        ]);

        $businessRequest -> update([
            'date_from' => request('date_from'),
            'date_to' => request('date_to'),
            'time_from' => request('time_from'),
            'time_to' => request('time_to'),
            'location' => request('location'),
            'purpose' => request('purpose'),
        ]);
        return response()->json(['success' => true, 'businessRequest' => $businessRequest],200);
    }//updateBusinessRequest()

    public function fetchID($id)
    {
        $fetchID = OfficialBusinessRequest::findOrFail($id);
        return response()->json(['success' => true, 'fetchID' => $fetchID],200);
    }//fetchID()

    public function approveBusinessRequest(Request $fetchdata,$id)
    {
        $status = 'Approved';
        $fetchdata = OfficialBusinessRequest::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata],200);
    }//approveBusinessRequest()

    public function declineBusinessRequest(Request $fetchdata,$id)
    {
        $status = 'Declined';
        $fetchdata = OfficialBusinessRequest::findOrFail($id);
        $fetchdata->update([
            'status_id' => $status
        ]);
        return response()->json(['success' => true, 'fetchdata' => $fetchdata],200);
    }//declineBusinessRequest()
    
    public function getData()
    {
        $user = Auth::user();
        $officialBusiness = Employee::where('user_id',$user->id)->with([
            'official_business_requests' => function ($q){
                $q->select('*');
            }
        ])->latest()->get();
        return response()->json(['sucess' => true, 'offcialBusiness' => $officialBusiness],200);
    }
}
