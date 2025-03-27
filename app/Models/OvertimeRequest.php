<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OvertimeRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'overtime_requests';

    protected $fillable = [
        'user_id',
        'employee_id',
        'day',
        'shift_date',
        'shift_from',
        'shift_to',
        'classification',
        'start',
        'end',
        'purpose',
        'status_id',
    ];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }
}
