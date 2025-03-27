<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndertimeUser extends Model
{
    use HasFactory;

    protected $table = 'undertime_user';

    protected $fillable = [
        'name',
        'requested_date',
        'amount',
        'status',
    ];
}
