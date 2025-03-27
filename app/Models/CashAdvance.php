<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CashAdvance extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'cash_advances';

    protected $fillable = [
        'user_id',
        'employee_id',
        'type_id',
        'requested_date',
        'date_approved',
        'date_decline',
        'reasons',
        'amount',
        'request_status',
        'deleted_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function types() {
        return $this->belongsTo(Types::class, 'type_id');
    }
}
