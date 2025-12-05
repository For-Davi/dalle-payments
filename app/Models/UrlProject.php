<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlProject extends Model
{
    protected $table = 'project_url';

    protected $fillable = [
        'base_url',
        'identifier',
    ];
}
