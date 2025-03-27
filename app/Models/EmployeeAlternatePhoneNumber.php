<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAlternatePhoneNumber extends Model
{
    use HasFactory;

    protected $table = 'employee_alternate_phone_numbers';
    protected $fillable = ['user_id','employee_id','title_id','phone_number','contact_person'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
