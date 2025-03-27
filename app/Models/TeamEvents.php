<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamEvents extends Model
{
    use HasFactory;

    protected $table = 'team_events';
    protected $fillable = ['id', 'employee_id', 'title', 'start', 'end', 'allDay', 'calendar', 'reason'];
    
}
