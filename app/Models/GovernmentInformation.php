<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GovernmentInformation extends Model
{
    use HasFactory;

    protected $table = 'government_informations';
    
    protected $fillable = [
        'user_id',
        'employee_id',
        'sss',
        'tin',
        'phil_health',
        'pag_ibig',
        'prc',
        'passport',
        'tax_status_id',
    ];

    public function tax_status()
    {
        return $this->belongsTo(TaxStatus::class, 'tax_status_id');
    }

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
