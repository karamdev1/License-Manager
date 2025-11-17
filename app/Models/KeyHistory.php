<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyHistory extends Model
{
    protected $table = 'key_history';

    protected $fillable = [
        'key_id',
        'key',
        'serial_number',
        'ip_address',
        'app',
        'status',
        'created_at',
        'updated_at',
    ];


    protected $hidden = [
        'id',
    ];
}
