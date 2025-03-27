<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxStatus extends Model
{
    use HasFactory;

    protected $table = 'tax_statuses';

    protected $fillable = [
        'name',
    ];
}
