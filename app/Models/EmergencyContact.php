<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyContact extends Model
{
    use HasFactory;
    protected $table = 'emergency_contacts';
    protected $fillable = ['user_id','employee_id','phone','relationship','name','address'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
