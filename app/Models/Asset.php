<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use App\Models\AssetCategory;
use App\Models\AssetCondition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $fillable = ['id', 'user_id','employee_id', 'item', 'category_id', 'condition_id', 'price', 'serial_number', 'date_acquired', 'date_issued', 'date_returned', 'notes'];

    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function category_action() 
    {
        return $this->belongsTo(AssetCategory::class, 'category_id'); 
    }

    public function condition_action() 
    {
        return $this->belongsTo(AssetCondition::class, 'condition_id'); 
    }
}
