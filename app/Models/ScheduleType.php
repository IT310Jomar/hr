<?php

namespace App\Models;

use App\Models\ScheduleConfiguration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScheduleType extends Model
{
    use HasFactory;

    protected $table = 'schedule_types';

    protected $fillable = [
        'id',
        'name',
    ];

    public function scheduleconfig()
    {
        return $this->hasMany(ScheduleConfiguration::class);
    }

}
