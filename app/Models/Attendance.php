<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
class Attendance extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'attendance_logs';

    protected $fillable = [
        'user_id',
        'employee_id',
        'login',
        'timeIn',
        'logout',
        'timeOut',
        'state',
        'type',
        'remarks'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setWeekNumberAttribute($value)
    {
        $this->attributes['week_number'] = Carbon::parse($this->date)->weekOfYear;
    }

}


