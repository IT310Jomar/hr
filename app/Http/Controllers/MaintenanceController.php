<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\UserLevels;
use Illuminate\Http\Request;
use App\Models\AssetCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MaintenanceController extends Controller
{
    // Asset Category CRUD
    public function showAssetCategory() {
        $data = array(
            'title' => 'Sirius - Assets'
        );
    
        return $data;
    }

    public function getAssetCategories() {
        $assets = AssetCategory::active()->get();

        return response() -> json(['success' => true, 'assets' => $assets]);
    }

    public function storeAssetCategory(Request $request) {
        $rules = array(
            'name' => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response(array(
                'status' => 'error',
                'message' => $validator->errors()->first()
            ), 400);
        }
    
        try {
            $assetCategory = AssetCategory::create($request->all());
            
            return response(array(
                'status' => 'success',
                'message' => 'Asset Category successfully added!'
            ), 200);
        } catch (Exception $e) {
            return response(array(
                'status' => 'error',
                'message' => 'There was an error while inserting the data: ' . $e->getMessage()
            ), 500);
        }
    }
    
    public function updateAssetCategory(AssetCategory $assets) {
        request()->validate([
            'name' => 'required',
        ]);

        $assets->update([
            'name' => request('name'),
        ]);

        return response() -> json(['success' => true, 'assets' => $assets]);
    }

    public function ViewAssetCategory($id){

        $assets = AssetCategory::find($id);

        return response()->json(['success' => true, 'assets' => $assets]);
    }


    public function deleteAssetCategory(AssetCategory $assets) {
        
        $assets->delete();
        
        return response()->noContent();
    }

    // Location CRUD
    public function showLocation() {
        $data = array(
            'title' => 'Sirius - Work Place'
        );
    
        return $data;
    }

    public function getLocation() {
        $location = Location::active()->get();

        return response() -> json(['success' => true, 'assets' => $location]);
    }

    public function storeLocation(Request $request) {
        $rules = array(
            'name' => 'required'
        );
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response(array(
                'status' => 'error',
                'message' => $validator->errors()->first()
            ), 400);
        }
    
        try {
            $location = Location::create($request->all());
            
            return response(array(
                'status' => 'success',
                'message' => 'Asset Category successfully added!'
            ), 200);
        } catch (Exception $e) {
            return response(array(
                'status' => 'error',
                'message' => 'There was an error while inserting the data: ' . $e->getMessage()
            ), 500);
        }
    }
    
    public function updateLocation(Location $locations) {
        request()->validate([
            'name' => 'required',
        ]);

        $locations->update([
            'name' => request('name'),
        ]);

        return response() -> json(['success' => true, 'assets' => $locations]);
    }

    public function ViewLocation($id){

        $locations = Location::find($id);

        return response()->json(['success' => true, 'assets' => $locations]);
    }


    public function deleteLocation(Location $locations) {
        
        $locations->delete();
        
        return response()->noContent();
    }

    public function privilege(Request $request) {
        $validatedData = $request->validate([
            'basicInfo' => 'string', // Validate each value in the array as a string (modify as needed)
            'workInfo' => 'string',
            'govInfo' => 'string',
            'accessInfo' => 'string',
            'uploadInfo' => 'string',
            'addEmployee' => 'string',
            'selectedEduc' => 'array',
            'selectedEduc.*' => 'string',
            'PM' => 'array', // Ensure values are present and an array
            'PM.*' => 'string',
            'contact' => 'array',
            'contact.*' => 'string',
            'dependent' => 'array',
            'dependent.*' => 'string',
            'benefit' => 'array',
            'benefit.*' => 'string',
            'leave' => 'array',
            'leave.*' => 'string',
            'salary' => 'array',
            'salary.*' => 'string',
            'advance' => 'array',
            'advance.*' => 'string',
            'asset' => 'array',
            'asset.*' => 'string',
            'memo' => 'array',
            'memo.*' => 'string',
            'seminar' => 'array',
            'seminar.*' => 'string',
            'empRec' => 'array',
            'empRec.*' => 'string',
            'movement' => 'array',
            'movement.*' => 'string',
            'medRec' => 'array',
            'medRec.*' => 'string',
            'requirements' => 'array',
            'requirements.*' => 'string',
            'scheduleInfo' => 'array',
            'scheduleInfo.*' => 'string',
            'docs' => 'array',
            'docs.*' => 'string',
            'calendar' => 'array',
            'calendar.*' => 'string',
            'attendance' => 'array',
            'attendance.*' => 'string',
            'myteam' => 'array',
            'myteam.*' => 'string',
            'empprofile' => 'boolean',
            'empsearch' => 'boolean',
            'leaveApp' => 'boolean',
            'overtime' => 'boolean',
            'undertime' => 'boolean',
            'offbusApp' => 'boolean',
            'coapp' => 'boolean',
            'saapp' => 'boolean',
            'emplistrep' => 'boolean',
            'emailblast' => 'boolean',
            'overtimeSearch' => 'boolean',
            'memoSearch' => 'boolean',
            'attendanceRep' => 'boolean',
        ]);
        $userLevel = request('user_level');
        $userName = UserLevels::select('name')->where('id', $userLevel)->first();
        $userPrivilege = UserLevels::where('id', $userLevel)->update([
            'privilege' => json_encode([$validatedData['basicInfo'], $validatedData['govInfo'], $validatedData['workInfo'], $validatedData['accessInfo'], $validatedData['uploadInfo'], $validatedData['addEmployee'], $validatedData['selectedEduc'], $validatedData['PM'], $validatedData['contact'], $validatedData['dependent'], $validatedData['benefit'], $validatedData['leave'], $validatedData['salary'], $validatedData['advance'], $validatedData['asset'], $validatedData['memo'], $validatedData['seminar'], $validatedData['empRec'], $validatedData['movement'], $validatedData['medRec'], $validatedData['requirements'], $validatedData['scheduleInfo'], $validatedData['docs'], $validatedData['calendar'], $validatedData['attendance'], $validatedData['myteam'], $validatedData['empprofile'], $validatedData['empsearch'], $validatedData['leaveApp'], $validatedData['overtime'], $validatedData['undertime'], $validatedData['offbusApp'], $validatedData['coapp'], $validatedData['saapp'], $validatedData['emplistrep'], $validatedData['emailblast'], $validatedData['overtimeSearch'], $validatedData['memoSearch'], $validatedData['attendanceRep']
            
        
        ]),
            'name' => $userName['name']
        ]);

        return response()->json(['success' => true, 'userName' => $userName, 'userlevel' => $userLevel, 'userPrivilege' => $userPrivilege]);
    }

    public function getprivilege() {
        
        $userPrivilege = UserLevels::latest()->get();

        $data = [];
        foreach($userPrivilege as $row) {
            $data[$row->id] = json_decode($row->privilege);
        }
    
        return response()->json(['success' => true, 'privilege' => $data]);
    }

    public function accessDelete()
    {
        $userLevelId = request('user_level'); // Assuming 'user_level' is the ID parameter
        $userPrivilege = UserLevels::find($userLevelId);
    
        if ($userPrivilege) {
            // Remove the privilege from the user_level record
            $userPrivilege->privilege = null;
            $userPrivilege->save();
    
            return response()->json(['success' => true, 'del-privilege' => $userPrivilege, 'user_level' => $userLevelId]);
        } else {
            return response()->json(['success' => false, 'message' => 'User privilege not found']);
        }
    }
    
    
}
