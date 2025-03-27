<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use App\Models\RequirementItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requirement extends Model
{
    use HasFactory;

    protected $table = 'requirements';
    protected $fillable = ['user_id','employee_id','requirement_name','notes','completed'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function requirements_item() 
    // {
    //     return $this->belongsTo(RequirementItem::class, 'requirement_name'); 
    // }
}
