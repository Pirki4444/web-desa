<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    protected $fillable = [
        'village_name',
        'district',
        'regency',
        'province',
        'postal_code',
        'history',
        'vision',
        'mission',
        'geography',
        'village_head_name',
        'village_head_photo',
        'village_head_message',
        'total_population',
        'total_families',
        'total_area',
        'total_dusun',
        'phone',
        'email',
        'address',
        'website',
    ];

    protected function casts(): array
    {
        return [
            'total_population' => 'integer',
            'total_families'   => 'integer',
            'total_area'       => 'decimal:2',
            'total_dusun'      => 'integer',
        ];
    }
}
