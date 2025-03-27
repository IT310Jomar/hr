<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageTeam extends Model
{
    protected $table = 'manage_team';

    protected $fillable = [
        'name',
        'position',
        'default_schedule',
    ];
}
