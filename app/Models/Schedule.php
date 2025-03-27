<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'day',
        'shift_start',
        'shift_end',
        'break_start',
        'break_end',
        'rest_day',
        'employee_id',
        'user_id',

    ];

    // public function employeeID() {
    //     return $this->hasMany(Employee::class);
    // }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
