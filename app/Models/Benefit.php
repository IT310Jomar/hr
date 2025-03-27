<?php

namespace App\Models;

use App\Models\User;
use App\Models\BenefitType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Benefit extends Model
{
    use HasFactory;

    protected $table = 'benefits';
    protected $fillable = ['id', 'user_id','employee_id', 'benefit_type_id', 'active', 'effective_date', 'enrollment_date', 'plan', 'beneficiary', 'notes', 'payment_type'];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function benefit_type() 
    {
        return $this->belongsTo(BenefitType::class, 'benefit_type_id'); 
    }
}
