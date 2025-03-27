<?php

namespace App\Models;

use App\Models\User;
use App\Models\DaType;
use App\Models\Employee;
use App\Models\OffenseLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Memos extends Model
{
    use HasFactory;
    protected $table = 'memo';
    protected $fillable = ['user_id','employee_id','offense_level','da_types','memo_subject','slide_date','memo_date','memo_note'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function offense_level()
    {
        return $this->belongsTo(OffenseLevel::class, 'offense_level');
    }

    public function da_Types()
    {
        return $this->belongsTo(DaType::class, 'da_types');
    }
}
