<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\EmploymentType;
use App\Models\EmploymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use HasFactory;

    protected $table = 'movements';
    protected $fillable = ['id', 'user_id','employee_id', 'date_from', 
    'date_to', 'from_position', 'from_department', 
    'from_employment_type_id', 'from_employment_status_id',
    'to_position', 'to_department', 'to_employment_type_id', 
    'to_employment_status_id', 'action_for', 'notes'];


    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
    
    public function employment_status() 
    {
        return $this->belongsTo(EmploymentStatus::class, 'from_employment_status_id'); 
    }

    public function employment_type() 
    {
        return $this->belongsTo(EmploymentType::class, 'from_employment_type_id'); 
    }
}
