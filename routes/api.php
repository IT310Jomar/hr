<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UndertimeController;
use App\Http\Controllers\ManageTeamController;
use App\Http\Controllers\CashAdvanceController;
use App\Http\Controllers\LeaveCreditController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\SiriusEmailController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\OfficialUserController;
use App\Http\Controllers\OvertimeUserController;
use App\Http\Controllers\ScheduleUserController;
use App\Http\Controllers\UndertimeUserController;
use App\Http\Controllers\CashAdvanceUserController;
use App\Http\Controllers\OfficialBusinessController;
use App\Http\Controllers\AttendanceRequestController;
use App\Http\Controllers\ResolutionController;
use App\Http\Controllers\ScheduleAdjustmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function ($router) {
    //Authentication
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/user-id', [AuthController::class, 'getUserID']);
    Route::put('/user-profile/changepass', [AuthController::class, 'Editpass']);
    Route::get('/password/user-password', [AuthController::class, 'getPasswordData']);

    // Route::get('/view-user-profile', [App\Http\Controllers\AuthController::class, 'viewUserProfile']);

});

Route::group(
    [
        'prefix' => 'user',
    ],
    function () {
        //Authentication
        // Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
        // Route::post('/register', [App\Http\Controllers\Admin\AuthController::class, 'register']);
        // Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout']);
        // Route::post('/refresh', [App\Http\Controllers\Admin\AuthController::class, 'refresh']);
        // Route::get('/user-profile', [App\Http\Controllers\Admin\AuthController::class, 'userProfile']);

        //Crud
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users/store', [UserController::class, 'store']);
        Route::put('/users/update/{user}', [UserController::class, 'update']);
        Route::get('/users/view/{user}', [UserController::class, 'view']);
        Route::delete('/users/delete/{user}', [UserController::class, 'delete']);
        Route::get('/users/search', [UserController::class, 'searchUser']);

        //Privilege
        Route::put('/maintenance/privilege', [MaintenanceController::class, 'privilege']);
        Route::get('/maintenance/get-privilege', [MaintenanceController::class, 'getprivilege']);
        Route::delete('/maintenance/delete-privilege', [MaintenanceController::class, 'accessDelete']);

        // Assets
        Route::get('/maintenance/assets', [MaintenanceController::class, 'showAssetCategory']);
        Route::post('/maintenance/asset', [MaintenanceController::class, 'storeAssetCategory']);
        Route::get('/maintenance/get-asset-categories', [MaintenanceController::class, 'getAssetCategories']);
        Route::delete('/maintenance/remove-asset-category/{assets}', [MaintenanceController::class, 'deleteAssetCategory']);
        Route::put('/maintenance/update-asset-category/{assets}', [MaintenanceController::class, 'updateAssetCategory']);
        Route::get('/maintenance/view-asset-category/{id}', [MaintenanceController::class, 'ViewAssetCategory']);

        // Location / Work place
        Route::get('/maintenance/work-place', [MaintenanceController::class, 'showLocation']);
        Route::post('/maintenance/location', [MaintenanceController::class, 'storeLocation']);
        Route::get('/maintenance/get-location', [MaintenanceController::class, 'getLocation']);
        Route::delete('/maintenance/remove-location/{locations}', [MaintenanceController::class, 'deleteLocation']);
        Route::put('/maintenance/update-location/{locations}', [MaintenanceController::class, 'updateLocation']);
        Route::get('/maintenance/view-location/{id}', [MaintenanceController::class, 'ViewLocation']);

        //Search based on status
        Route::get('/cash/advance/search', [CashAdvanceController::class, 'searchrequestPending']);
        Route::get('/cash/advance/search/approved', [CashAdvanceController::class, 'searchrequestApproved']);
        Route::get('/cash/advance/search/declined', [CashAdvanceController::class, 'searchrequestDeclined']);

        //Cash Advance Request
        Route::get('/cash/advance', [CashAdvanceController::class, 'requestCashAdvance']);
        Route::get('/cash/advance/fetchdata/{id}', [CashAdvanceController::class, 'fetchID']);
        Route::get('/cash/advance/view/{id}', [CashAdvanceController::class, 'view']);
        Route::post('/cash/advance/createrequest', [CashAdvanceController::class, 'store']);
        Route::put('/cash/advance/update/{cashAdvance}', [CashAdvanceController::class, 'updateRequest']);
        Route::get('/cash/advance/approved', [CashAdvanceController::class, 'requestCashApproved']);
        Route::get('/cash/advance/declined', [CashAdvanceController::class, 'requestCashDeclined']);
        Route::put('/cash/advance/approverequest/{id}', [CashAdvanceController::class, 'approveRequest']);
        Route::put('/cash/advance/declinerequest/{id}', [CashAdvanceController::class, 'declinedRequest']);
        Route::get('/cash/advance/getdata', [CashAdvanceController::class, 'getData']);

        //Leave
        Route::get('/leave/index', [LeaveRequestController::class, 'index']);
        Route::get('/leave/request', [LeaveRequestController::class, 'requestLeave']);
        Route::get('/leave/request/approved', [LeaveRequestController::class, 'requestLeaveApproved']);
        Route::get('/leave/request/declined', [LeaveRequestController::class, 'requestLeaveDeclined']);
        Route::post('/leave/request/store', [LeaveRequestController::class, 'store']);
        Route::get('/leave/request/view/{id}', [LeaveRequestController::class, 'view']);
        Route::put('/leave/request/update/{leaveRequest}', [LeaveRequestController::class, 'updateLeaveRequest']);
        Route::get('/leave/request/fetchdata/{id}', [LeaveRequestController::class, 'fetchID']);
        Route::put('/leave/request/approved/leaverequest/{id}', [LeaveRequestController::class, 'approveLeaveRequest']);
        Route::put('/leave/request/declined/leaverequest/{id}', [LeaveRequestController::class, 'declineLeaveRequest']);
        Route::get('/leave/request/getdata', [LeaveRequestController::class, 'getData']);


        Route::get('/leave/count', [LeaveCreditController::class, 'leave']);
        Route::put('/leave/update/{leavecredit}', [LeaveCreditController::class, 'leaveUpdate']);

        //Search Leave based on Status
        Route::get('/leave/request/search', [LeaveRequestController::class, 'searchrequestPending']);
        Route::get('/leave/request/search/approved', [LeaveRequestController::class, 'searchrequestApproved']);
        Route::get('/leave/request/search/declined', [LeaveRequestController::class, 'searchrequestDeclined']);

        //Attendance Request
        Route::get('/attendance/request', [AttendanceRequestController::class, 'requestAttendance']);
        Route::get('/attendance/request/approved', [AttendanceRequestController::class, 'requestAttendanceApproved']);
        Route::get('/attendance/request/declined', [AttendanceRequestController::class, 'requestAttendanceDeclined']);
        Route::post('/attendance/request/store', [AttendanceRequestController::class, 'store']);
        Route::get('/attendance/getdata', [AttendanceRequestController::class, 'getData']);
        Route::put('/attendance/request/update/{attendancereq}', [AttendanceRequestController::class, 'updateAttendanceRequest']);
        Route::get('/attendance/request/view/{id}', [AttendanceRequestController::class, 'view']);
        Route::put('/attendance/request/approvedreq/{id}', [AttendanceRequestController::class, 'approveAttendanceRequest']);
        Route::put('/attendance/request/declinedreq/{id}', [AttendanceRequestController::class, 'declineAttendanceRequest']);

        //Search Attendance based on Status
        Route::get('/attendance/request/search', [AttendanceRequestController::class, 'searchrequestPending']);
        Route::get('/attendance/request/search/approved', [AttendanceRequestController::class, 'searchrequestApproved']);
        Route::get('/attendance/request/search/declined', [AttendanceRequestController::class, 'searchrequestDeclined']);

        //Schedule Adjustment
        Route::get('/schedule/adjustment', [ScheduleAdjustmentController::class, 'requestSchedule']);
        Route::get('/schedule/adjustment/approved', [ScheduleAdjustmentController::class, 'requestScheduleApproved']);
        Route::get('/schedule/adjustment/declined', [ScheduleAdjustmentController::class, 'requestScheduleDeclined']);
        Route::post('/schedule/adjustment/store', [ScheduleAdjustmentController::class, 'store']);
        Route::get('/schedule/adjustment/view/{id}', [ScheduleAdjustmentController::class, 'view']);
        Route::put('/schedule/adjustment/update/{scheduleRequest}', [ScheduleAdjustmentController::class, 'updateScheduleRequest']);
        Route::get('/schedule/adjustment/fetchdata/{id}', [ScheduleAdjustmentController::class, 'fetchID']);
        Route::put('/schedule/adjustment/approved/schedulerequest/{id}', [ScheduleAdjustmentController::class, 'approveScheduleRequest']);
        Route::put('/schedule/adjustment/declined/schedulerequest/{id}', [ScheduleAdjustmentController::class, 'declineScheduleRequest']);
        Route::get('/schedule/adjustment/getdata', [ScheduleAdjustmentController::class, 'getData']);

        //Search Schedule Adjustment based on Status
        Route::get('/schedule/adjustment/search', [ScheduleAdjustmentController::class, 'searchrequestPending']);
        Route::get('/schedule/adjustment/search/approved', [ScheduleAdjustmentController::class, 'searchrequestApproved']);
        Route::get('/schedule/adjustment/search/declined', [ScheduleAdjustmentController::class, 'searchrequestDeclined']);

        //Overtime Request
        Route::get('/overtime/request/data', [OvertimeController::class, 'index']);
        Route::get('/overtime/request', [OvertimeController::class, 'requesOvertimePending']);
        Route::get('/overtime/request/approved', [OvertimeController::class, 'requestOvertimeApproved']);
        Route::get('/overtime/request/declined', [OvertimeController::class, 'requestOvertimeDeclined']);
        Route::post('/overtime/request/store', [OvertimeController::class, 'store']);
        Route::get('/overtime/request/view/{id}', [OvertimeController::class, 'view']);
        Route::put('/overtime/request/update/{overtimeRequest}', [OvertimeController::class, 'updateOvertimeRequest']);
        Route::get('/overtime/request/fetchdata/{id}', [OvertimeController::class, 'fetchID']);
        Route::put('/overtime/request/approved/overtimerequest/{id}', [OvertimeController::class, 'approveOvertimeRequest']);
        Route::put('/overtime/request/declined/overtimerequest/{id}', [OvertimeController::class, 'declineOvertimeRequest']);
        Route::get('/overtime/request/getdata', [OvertimeController::class, 'getData']);

        //Search Overtime Requests based on Status
        Route::get('/overtime/request/search', [OvertimeController::class, 'searchrequestPending']);
        Route::get('/overtime/request/search/approved', [OvertimeController::class, 'searchrequestApproved']);
        Route::get('/overtime/request/search/declined', [OvertimeController::class, 'searchrequestDeclined']);

        //Undertime Request
        Route::get('/undertime/request', [UndertimeController::class, 'requestUndertime']);
        Route::get('/undertime/request/approved', [UndertimeController::class, 'requestUndertimeApproved']);
        Route::get('/undertime/request/declined', [UndertimeController::class, 'requestUndertimeDeclined']);
        Route::post('/undertime/request/store', [UndertimeController::class, 'store']);
        Route::get('/undertime/request/view/{id}', [UndertimeController::class, 'view']);
        Route::put('/undertime/request/update/{undertimeRequest}', [UndertimeController::class, 'updateUndertimeRequest']);
        Route::get('/undertime/request/fetchdata/{id}', [UndertimeController::class, 'fetchID']);
        Route::put('/undertime/request/approved/undertimerequest/{id}', [UndertimeController::class, 'approveScheduleRequest']);
        Route::put('/undertime/request/declined/undertimerequest/{id}', [UndertimeController::class, 'declineScheduleRequest']);
        Route::get('/undertime/request/getdata', [UndertimeController::class, 'getData']);

        //Search Undertime Requests based on Status
        Route::get('/undertime/request/search', [UndertimeController::class, 'searchrequestPending']);
        Route::get('/undertime/request/search/approved', [UndertimeController::class, 'searchrequestApproved']);
        Route::get('/undertime/request/search/declined', [UndertimeController::class, 'searchrequestDeclined']);

        //Official Business Request
        Route::get('/business/request', [OfficialBusinessController::class, 'businessRequest']);
        Route::get('/business/request/approved', [OfficialBusinessController::class, 'businessRequestApproved']);
        Route::get('/business/request/declined', [OfficialBusinessController::class, 'businessRequestDeclined']);
        Route::post('/business/request/store', [OfficialBusinessController::class, 'store']);
        Route::get('/business/request/view/{id}', [OfficialBusinessController::class, 'view']);
        Route::put('/business/request/update/{businessRequest}', [OfficialBusinessController::class, 'updateBusinessRequest']);
        Route::get('/business/request/fetchdata/{id}', [OfficialBusinessController::class, 'fetchID']);
        Route::put('/business/request/approved/businessrequest/{id}', [OfficialBusinessController::class, 'approveBusinessRequest']);
        Route::put('/business/request/declined/businessrequest/{id}', [OfficialBusinessController::class, 'declineBusinessRequest']);
        Route::get('/business/request/getdata', [OfficialBusinessController::class, 'getData']);

        //Search Business Requests based on Status
        Route::get('/business/request/search', [OfficialBusinessController::class, 'searchrequestPending']);
        Route::get('/business/request/search/approved', [OfficialBusinessController::class, 'searchrequestApproved']);
        Route::get('/business/request/search/declined', [OfficialBusinessController::class, 'searchrequestDeclined']);

        //Manage team
        Route::post('/manage_team/store', [ManageTeamController::class, 'store']);
        Route::get('/manage_team/view', [ManageTeamController::class, 'index']);
        Route::get('/manage_team/search', [ManageTeamController::class, 'search']);

        //Overtime
        Route::post('/overtime_user/store', [OvertimeUserController::class, 'store']);
        Route::get('/overtime_user/view', [OvertimeUserController::class, 'index']);

        //Undertime
        Route::post('/undertime_user/store', [UndertimeUserController::class, 'store']);
        Route::get('/undertime_user/view', [UndertimeUserController::class, 'index']);

        //CashAdvance
        Route::post('/cashadvance_user/store', [CashAdvanceUserController::class, 'store']);
        Route::get('/cashadvance_user/view', [CashAdvanceUserController::class, 'index']);

        //ScheduleAdjustment
        Route::post('/schedule_user/store', [ScheduleUserController::class, 'store']);
        Route::get('/schedule_user/view', [ScheduleUserController::class, 'index']);

        //OfficialBusiness
        Route::post('/official_user/store', [OfficialUserController::class, 'store']);
        Route::get('/official_user/view', [OfficialUserController::class, 'index']);

        //Leave
        Route::post('/leave_user/store', [LeaveRequestController::class, 'store']);
        Route::get('/leave_user/view', [LeaveRequestController::class, 'index']);
        

        //AddEmployee
        //Basic Employee Info
        Route::get('/employees/employee-search', [EmployeeController::class, 'employee_search']);
        Route::get('/employees/getEmployee', [EmployeeController::class, 'getEmployeeList']);
        Route::post('/employees/store', [EmployeeController::class, 'store']);
        Route::get('/employees/view/{id}', [EmployeeController::class, 'view']);
        Route::get('/employees/getEmploymentOptions', [EmployeeController::class, 'getEmploymentOptions']);
        Route::get('/employees/deleteItems/{id}', [EmployeeController::class, 'deleteItemInfo']);
        Route::get('/employees/viewEmployee/{id}', [EmployeeController::class, 'viewProfileEmployee']);
        Route::get('/employees/email', [EmployeeController::class, 'getEmployeeEmail']);

        //Dashboard
        Route::get('/dashboard/mystuff/pending', [DashboardController::class, 'getAllPending']);
        Route::get('/dashboard/updates/incident', [DashboardController::class, 'getIncident']);
        Route::get('/dashboard/headcounts/employees/regular', [DashboardController::class, 'headCount']);
        Route::get('/dashboard/headcounts/employees/contigents', [DashboardController::class, 'countContigents']);

        //EditEmployee
        Route::put('/employees/edit/{id}', [EmployeeController::class, 'editEmployeeDetails']);
        Route::put('/employees/schedule_config/edit/{id}', [EmployeeController::class, 'editScheduleConfig']);

        Route::get('/schedule_config/view', [EmployeeController::class, 'scheduleConfig']);
        Route::get('/schedule_config/getData', [EmployeeController::class, 'scheduleConfiguration']);

        Route::get('/schedule_config', [EmployeeController::class, 'scheduleConfig']);
        Route::get('/schedule_config/getID/{id}', [EmployeeController::class, 'GetID_scheduletype']);

        Route::get('/schedule_categories/getscheduledata', [EmployeeController::class, 'getScheduleCategories']);
        Route::post('/schedulecreates/store', [EmployeeController::class, 'storeschedulecategories']);
        Route::put('/schedule_categories/update-schedule-data/{schedule_configuration}', [EmployeeController::class, 'updateScheduleCategory']);
        Route::delete('/schedule_categories/delete-schedule-data/{id}', [EmployeeController::class, 'DeleteScheduleCategory']);
        Route::get('/schedule_categories/view-schedule-data/{schedule_configuration}', [EmployeeController::class, 'ViewScheduleCategory']);

        //EmployeeSearch
        Route::get('/employee_directory/search', [EmployeeController::class, 'employeedirectorysearch']);


        //work schedule info
        Route::get('/schedules/view', [EmployeeController::class, 'viewSchedule']);

        //tax Status
        Route::get('/tax_statuses/view', [EmployeeController::class, 'viewTaxStatus']);

        //memo
        Route::get('/memo/view', [EmployeeController::class, 'getMemo']);
        Route::post('/memocreate/store', [EmployeeController::class, 'Creatememo']);
        Route::get('/memo/search', [EmployeeController::class, 'searchrequestMemo']);
        Route::put('/memo/update-memo-data/{memos}', [EmployeeController::class, 'updateMemo']);
        Route::delete('/memo/delete-memo-data/{id}', [EmployeeController::class, 'DeleteMemo']);
        Route::get('/memo/view-memo-data/{memos}', [EmployeeController::class, 'ViewMemo']);
        Route::get('/memo/searchRange', [EmployeeController::class, 'MemoRangeSearch']);


        //Manage attendance
        Route::get('/attendance/view', [EmployeeController::class, 'getAttendance']);
        Route::post('/attendancecreate/store', [EmployeeController::class, 'storeData']);
        Route::get('/attendancelogs/view', [EmployeeController::class, 'getSpecificAttendanceData']);
        Route::get('/employees/get-employee-data', [EmployeeController::class, 'getAttendance']);
        Route::put('/attendance/editAttendance/{id}', [EmployeeController::class, 'editAttendance']);
        Route::get('/attendance/searchRange', [EmployeeController::class, 'rangeSearch']);
        Route::get('/attendance/search', [EmployeeController::class, 'Search']);

        //EmployeeList Search
        Route::get('/employeelist/search', [EmployeeController::class, 'listSearch']);

        //OvertimeList Search
        Route::get('/employees/overtime_request', [EmployeeController::class, 'overtimeRequest']);
        Route::get('/overtimelist/search', [EmployeeController::class, 'overtimelistSearch']);
        Route::get('/overtime/searchRange', [EmployeeController::class, 'OvertimerangeSearch']);

        //Undertime request
        Route::get('/employees/undertime_request', [EmployeeController::class, 'undertimeRequest']);
        Route::get('/employees/undertime/search', [EmployeeController::class, 'undertimeSearch']);
        Route::get('/undertime/searchRange', [EmployeeController::class, 'UndertimerangeSearch']);

        //leave request
        Route::get('/employees/leave_report', [EmployeeController::class, 'leaveRequest']);
        Route::get('/leave/searchRange', [EmployeeController::class, 'leaveSearchRange']);
        Route::get('/maintenance/leavesettings', [EmployeeController::class, 'leaveSettingData']);
        Route::post('/leave/leavesettings', [EmployeeController::class, 'LeaveSettingsStore']);
        Route::put('/leave/editleave/{id}', [EmployeeController::class, 'editLeaveSettings']);
        Route::delete('/leavesettings/deleteData/{id}', [EmployeeController::class, 'DeleteLeave']);
        Route::get('/Leave/viewLeave/{leave_settings}', [EmployeeController::class, 'ViewLeave']);
    
        //incident request
        Route::post('incidentreport/store', [EmployeeController::class, 'storeIncident']);

        // Management Team
        Route::get('/manage/manage-team/get-schedule', [ManageTeamController::class, 'getSchedule']);
        Route::get('/manage/manage-team/get-all', [ManageTeamController::class, 'allEmployee']);
        Route::get('/manage/manage-team/get-search', [ManageTeamController::class, 'search']);
        Route::post('/manage/manage-team/add-event', [ManageTeamController::class, 'addEvent']);
        Route::get('/manage/manage-team/get-events', [ManageTeamController::class, 'getEvents']);
        Route::post('/manage/manage-team/update-events/{id}', [ManageTeamController::class, 'updateEvent']);
        Route::delete('/manage/manage-team/delete-event/{id}', [ManageTeamController::class, 'deleteEvent']);
        Route::get('/manage/manage-team/get-team-attendance', [ManageTeamController::class, 'getTeamAttendance']);

        Route::get('/manage/manage-team/get-team-employees', [ManageTeamController::class, 'getEmployees']);
        Route::post('/manage/manage-team/add-team-event', [ManageTeamController::class, 'addTeamEvent']);
        Route::get('/manage/manage-team/get-team-events', [ManageTeamController::class, 'getTeamEvents']);
        Route::post('/manage/manage-team/update-team-events/{id}', [ManageTeamController::class, 'updateTeamEvent']);
        Route::delete('/manage/manage-team/delete-team-event/{id}', [ManageTeamController::class, 'deleteTeamEvent']);

        // Resolution Center
        Route::get('/resolution/resolution-center/getPending', [ResolutionController::class, 'requestCashAdPending']);
        Route::get('/resolution/resolution-center/getApprove', [ResolutionController::class, 'requestCashAdApprove']);
        Route::get('/resolution/request-types', [ResolutionController::class, 'getRequestTypes']);
        Route::get('/resolution/get-compay', [ResolutionController::class, 'getCompany']);
        Route::get('/resolution/get-types', [ResolutionController::class, 'getTypes']);
        Route::get('/resolution/resolution-center/delete-request/{id}', [ResolutionController::class, 'deleteRequest']);
        Route::get('/resolution/resolution-center/delete-request-cash/{id}', [ResolutionController::class, 'deleteRequestCashAd']);
        Route::get('/resolution/resolution-center/delete-request-leave/{id}', [ResolutionController::class, 'deleteRequestLeave']);
        Route::get('/resolution/resolution-center/delete-request-officialBuisness/{id}', [ResolutionController::class, 'deleteRequestOffBusiness']);
        Route::get('/resolution/resolution-center/delete-request-overtime/{id}', [ResolutionController::class, 'deleteRequesOvertime']);
        Route::get('/resolution/resolution-center/delete-request-attendance/{id}', [ResolutionController::class, 'deleteRequesAttendance']);
        Route::get('/resolution/resolution-center/delete-request-undtertime/{id}', [ResolutionController::class, 'deleteRequesUndetime']);















































































        //Sirius Email Controller
        Route::post('/admin/tools/email-blast/send-email', [SiriusEmailController::class, 'sendEmail']);

    },
);
