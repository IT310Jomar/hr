<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;
    protected $table = 'memos';

    protected $fillable = [
        'to_address',
        'from_address',
        'memo_subject',
        'memo_date',
        'memo_message',
    ];
}
