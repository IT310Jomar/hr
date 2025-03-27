<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    
    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    protected $table = 'locations';

    protected $fillable = [
        'name',
        'status',
    ];

    
}
