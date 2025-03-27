<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ScheduleAdjustment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'schedule_adjustments';
    protected $fillable = [
        'user_id',
        'employee_id',
        'type_id',
        'date_from',
        'date_to',
        'shift_start',
        'shift_end',
        'break_start',
        'break_end',
        'status_id',
        'deleted_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function types() {
        return $this->belongsTo(Types::class, 'type_id');
    }
}
