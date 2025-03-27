<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dependent extends Model
{
    use HasFactory;

    protected $table = 'dependents';
    protected $fillable = ['id', 'user_id','employee_id', 'first_name', 'last_name', 'middle_name', 'relationship', 'birthdate','gender', 'notes'];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
