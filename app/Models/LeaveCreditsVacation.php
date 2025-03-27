<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveCreditsVacation extends Model
{
    use HasFactory;

    protected $table = 'leave_credits_vacations';
    protected $fillable = ['employee_id','name','credits','reasons'];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
