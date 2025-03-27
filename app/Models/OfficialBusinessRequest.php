<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OfficialBusinessRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'official_business_requests';

    protected $fillable = [
            'user_id',
            'employee_id',
            'date_from',
            'date_to',
            'time_from',
            'time_to',
            'location',
            'purpose',
            'status_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
