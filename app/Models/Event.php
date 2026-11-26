<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'location',
        'organizer',
        'status',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'start_datetime' => 'datetime',
            'end_datetime'   => 'datetime',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'upcoming'  => 'Akan Datang',
            'ongoing'   => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default     => 'Tidak Diketahui',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'upcoming'  => 'emerald',
            'ongoing'   => 'blue',
            'completed' => 'gray',
            'cancelled' => 'red',
            default     => 'gray',
        };
    }
}
