<?php

namespace App\Models;

use App\Models\LeaveCredit;
use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'name',
    ];

    public function leave_credits()
    {
        return $this->hasOne(LeaveCredit::class);
    }

    public function leave_requests()
    {
        return $this->hasOne(LeaveRequest::class);
    }

}
