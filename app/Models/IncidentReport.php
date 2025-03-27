<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    use HasFactory;

    protected $table = 'incident_reports';

    protected $fillable = [
        'user_id',
        'employee_id',
        'offense_level_id',
        'account',
        'immediate_head',
        'incident',
        'dt_of_incident',
        'status_id',
    ];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }


}
