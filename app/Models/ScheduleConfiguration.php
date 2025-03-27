<?php

namespace App\Models;

use App\Models\ScheduleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScheduleConfiguration extends Model
{
    use HasFactory;

    protected $table = 'schedule_configuration';
    protected $fillable = ['id','day', 'schedule_type_id', 'shift_start', 'shift_end', 'break_start', 'break_end', 'rest_day'];

    public function scheduletypes()
    {
        return $this->belongsTo(ScheduleType::class, 'schedule_type_id');
    }
}
