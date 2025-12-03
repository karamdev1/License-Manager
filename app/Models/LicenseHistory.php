<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseHistory extends Model
{
    protected $table = 'licenses_history';

    protected $fillable = [
        'license_id',
        'type',
        'user',
        'created_at',
        'updated_at',
    ];


    protected $hidden = [
        'id',
    ];
}
