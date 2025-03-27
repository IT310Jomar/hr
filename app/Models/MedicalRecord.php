<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'medical_records';
    protected $fillable = ['user_id','employee_id','file_name','creation_time','classification','notes'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
