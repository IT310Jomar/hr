<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';
    protected $fillable = ['id', 'user_id','employee_id', 'name', 'account_number'];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
