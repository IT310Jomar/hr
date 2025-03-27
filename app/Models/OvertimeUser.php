<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeUser extends Model
{
    use HasFactory;

    protected $table = 'overtime_user';

    protected $fillable = [
        'name',
        'requested_date',
        'amount',
        'status',
    ];
}
