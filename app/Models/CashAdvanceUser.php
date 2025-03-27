<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashAdvanceUser extends Model
{
    use HasFactory;

    protected $table = 'cashadvance_user';

    protected $fillable = [
        'name',
        'requested_date',
        'amount',
        'status',
    ];
}
