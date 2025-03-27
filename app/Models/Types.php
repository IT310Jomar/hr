<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    use HasFactory;

    protected $table = 'types';
    protected $fillable = ['id', 'name'];

    public function cash_advance() {
        return $this->hasOne(CashAdvance::class);
    }

    public function schedule_adjustment() {
        return $this->hasOne(ScheduleAdjustment::class);
    }
}
