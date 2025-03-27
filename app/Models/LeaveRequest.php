<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveRequest extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'leave_requests';

    protected $fillable = [
        'employee_id',
        'user_id',
        'leave_type',
        'date_from',
        'date_to',
        'reason',
        'file_attachment',
        'status_id',
        'deleted_at'
    ];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }
    public function deparments() 
    {
        return $this->belongsTo(Department::class, 'department_id'); 
    }
}
