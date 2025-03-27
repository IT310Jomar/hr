<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleUser extends Model
{
    use HasFactory;

    protected $table = 'schedule_user';

    protected $fillable = [
        'name',
        'requested_date',
        'amount',
        'status',
    ];
}
