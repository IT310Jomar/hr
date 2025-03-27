<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLevels;
class Events extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $fillable = ['id', 'role_id', 'title', 'start', 'end', 'location', 'description'];

    protected $cast = [
        'role_id' => 'array',
        // other casts
    ];

    public function user_level() {
        return $this->belongsTo(UserLevels::class);
    }
}
