<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $fillable = ['user_id','employee_id','local_trunk_line','pin','skype_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
