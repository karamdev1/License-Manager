<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\License;
use App\Models\AppHistory;

class App extends Model
{
    protected $table = 'apps';

    protected $fillable = [
        'app_id',
        'name',
        'price',
        'status',
        'registrar',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'edit_id',
        'id',
    ];

    protected static function booted()
    {
        static::creating(function ($app) {
            if (empty($app->app_id)) {
                $app->app_id = (string) \Illuminate\Support\Str::uuid();
            }

            if (empty($app->edit_id)) {
                $app->edit_id = (string) \Illuminate\Support\Str::uuid();
            }
        });

        static::deleting(function ($app) {
            $app->licenses()->delete();
            $app->histories()->delete();
        });
    }

    public function licenses()
    {
        return $this->hasMany(License::class, 'app_id', 'app_id');
    }

    public function histories()
    {
        return $this->hasMany(AppHistory::class, 'app_id', 'edit_id');
    }
}
