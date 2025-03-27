<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UndertimeRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'undertime_requests';

    protected $fillable = [
        'user_id',
        'employee_id',
        'date_req',
        'from',
        'to',
        'total_hours',
        'reason',
        'status_id',
    ];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }
}
