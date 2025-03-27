<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Department;
use App\Models\ScheduleType;
use App\Models\EmploymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employments extends Model
{
    use HasFactory;

    protected $table = 'employments';
    
    protected $fillable = [
        'department_id',
        'location_id',
        'job_grade',
        'billability',
        'type',
        'title',
        'date_hired',
        'date_regularization',
        'status_id',
        'remarks',
        'biometric',
        'payroll_type',
        'payroll_pie_id',
        'schedule_type_id',
        'working_hours',
        'employee_id',
        'user_id',
    ];

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function employmentstatus()
    {
        return $this->belongsTo(EmploymentStatus::class, 'status_id');
    }

    public function schedule_types()
    {
        return $this->belongsTo(ScheduleType::class, 'schedule_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
  

  
    

