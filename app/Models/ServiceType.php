<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'requirements',
        'estimated_time',
        'fee',
        'is_active',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'requirements' => 'array',
            'is_active'    => 'boolean',
            'order'        => 'integer',
        ];
    }

    public function requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
