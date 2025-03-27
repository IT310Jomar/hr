<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeEmail extends Model
{
    use HasFactory;

    protected $table = 'employee_emails';
    protected $fillable = ['employee_id','user_id','email','primary'];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
