<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;

    protected $table = 'education';
    protected $fillable = ['id', 'user_id' ,'employee_id', 'education_type_id', 'school', 'from', 'to', 'degree'];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    public function education_type() 
    {
        return $this->belongsTo(EducationType::class, 'education_type_id'); 
    }
}
