<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveCredit extends Model
{
    use HasFactory;

    protected $table = 'leave_credits';

    protected $fillable = [
        'user_id',
        'employee_id',
        'department_id',
        'sick_leave_credits',
        'vacation_leave_credits',
        'reasons'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function departments(){
        return $this->belongsTo(Department::class, 'department_id');
    }
}
