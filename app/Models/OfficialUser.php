<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialUser extends Model
{
    use HasFactory;

    protected $table = 'official_user';

    protected $fillable = [
        'name',
        'requested_date',
        'amount',
        'status',
    ];
}
