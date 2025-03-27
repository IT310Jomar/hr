<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use App\Models\SalaryAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salaries';
    protected $fillable = ['user_id','employee_id', 'date_from', 'base_salary', 'others_type', 'other_supplies', 'monthly_gross', 'percentage_increase', 'raise_amount', 'raise_percentage','commission', 'salary_action_id', 'notes','clothing','communication','discretionary','laundry','meal','medical','productivity','rice','transportation','travel','others'];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function salary_action() 
    {
        return $this->belongsTo(SalaryAction::class, 'salary_action_id'); 
    }
}
