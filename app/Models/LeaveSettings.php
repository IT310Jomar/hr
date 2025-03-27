<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\UserLevels;
use App\Models\Employments;
use App\Models\EmploymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveSettings extends Model
{
    use HasFactory;

    protected $table = 'leave_settings';

    protected $fillable = [
        'user_id',
        'employee_id',
        'user_level',
        'leave_count',
        'description',
    ];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    // public function employmentstatus()
    // {
    //     return $this->hasOne(EmploymentStatus::class);
    // }

    public function user_levels()
    {
        return $this->belongsTo(UserLevels::class, 'user_id');
    }


}
