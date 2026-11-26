<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageOfficial extends Model
{
    protected $fillable = [
        'name',
        'position',
        'nip',
        'phone',
        'photo',
        'description',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order'     => 'integer',
        ];
    }
}
