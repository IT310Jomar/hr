<?php

namespace App\Models;
use App\Models\Events;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\LeaveSettings;
use Illuminate\Database\Eloquent\Model;

class UserLevels extends Model
{
    protected $table = 'user_levels';

    protected $fillable = [
        'name',
        'privilege',
    ];

    public function events() {
        return $this->hasMany(Events::class);
    }

    // public function leave_settings() 
    // {
    //     return $this->hasOne(LeaveSettings::class); 
    // }
}
