<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\Memo;
use App\Models\User;
use App\Models\Asset;
use App\Models\Memos;
use App\Models\Salary;
use App\Models\Benefit;
use App\Models\Contact;
use App\Models\Document;
use App\Models\Location;
use App\Models\Movement;
use App\Models\Schedule;
use App\Models\Dependent;
use App\Models\Education;
use App\Models\Department;
use App\Models\UserLevels;
use App\Models\Employments;
use App\Models\LeaveCredit;
use App\Models\Requirement;
use App\Models\LeaveRequest;
use App\Models\ScheduleType;
use App\Models\EmployeeEmail;
use App\Models\LeaveSettings;
use App\Models\EmployeeRecord;
use App\Models\IncidentReport;
use App\Models\OvertimeRequest;
use App\Models\EmergencyContact;
use App\Models\EmploymentStatus;
use App\Models\LeaveCreditsSick;
use App\Models\UndertimeRequest;
use App\Models\ScheduleAdjustment;
use App\Models\GovernmentInformation;
use App\Models\OfficialBusinessRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeAlternatePhoneNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'civil_status',
        'birthdate',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contacts()
    {
        return $this->hasOne(Contact::class);
    }

    public function emergency()
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function alternate()
    {
        return $this->hasMany(EmployeeAlternatePhoneNumber::class);
    }
    
    public function email()
    {
        return $this->hasMany(EmployeeEmail::class);
    }

    public function dependents()
    {
        return $this->hasMany(Dependent::class);
    }

    public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function salaries()
    {
        return $this->hasOne(Salary::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function memo()
    {
        return $this->hasMany(Memos::class);
    }

    public function leave_credits_sick()
    {
        return $this->hasOne(LeaveCredit::class);
    }

    public function leave_credits_vacation()
    {
        return $this->hasOne(LeaveCredit::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function employee_rec()
    {
        return $this->hasMany(EmployeeRecord::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
    public function medical_record()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    
    public function schedule_employee()
    {
        return $this->hasMany(Schedule::class);
    }

    public function employments()
    {
        return $this->hasOne(Employments::class, 'employee_id');
    }
     
    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'employee_id');
    }

        public function attendance_logs()
    {
        return $this->hasMany(Attendance::class);
    }

    public function government()
    {
        return $this->hasOne(GovernmentInformation::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function leave_credits()
    {
        return $this->hasMany(LeaveCredit::class);
    }

    public function overtime_requests()
    {
        return $this->hasMany(OvertimeRequest::class);
    }
    public function undertime_requests()
    {
        return $this->hasMany(UndertimeRequest::class);
    }
    public function leave_requests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
    public function cash_advances()
    {
        return $this->hasMany(CashAdvance::class);
    }
    public function schedule_adjustments()
    {
        return $this->hasMany(ScheduleAdjustment::class);
    }
    public function official_business_requests()
    {
        return $this->hasMany(OfficialBusinessRequest::class);
    }
    public function incident_reports()
    {
        return $this->hasMany(IncidentReport::class);
    }
    public function leave_settings()
    {
        return $this->hasMany(LeaveSettings::class);
    }
}
