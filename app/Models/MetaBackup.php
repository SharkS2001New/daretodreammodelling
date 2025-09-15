<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaBackup extends Model
{
    protected $fillable = ['data'];

    protected $casts = [
        'data' => 'array',
    ];
}
