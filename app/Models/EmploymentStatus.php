<?php

namespace App\Models;

use App\Models\Employments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmploymentStatus extends Model
{
    use HasFactory;
    protected $table = 'employment_statuses';

    protected $fillable = [
        'name',
    ];

    public function employments()
    {
        return $this->hasOne(Employments::class);
    }
}
