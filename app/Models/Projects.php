<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $fillable = [
        'name',
        'api_key',
        'active',
    ];

    protected $hidden = [
        'api_key',
    ];
}
