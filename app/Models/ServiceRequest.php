<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'tracking_code',
        'service_type_id',
        'applicant_name',
        'nik',
        'phone',
        'description',
        'status',
        'admin_note',
        'processed_by',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'processed_at' => 'datetime',
        ];
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
            default    => 'Tidak Diketahui',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'amber',
            'diproses' => 'blue',
            'selesai'  => 'emerald',
            'ditolak'  => 'red',
            default    => 'gray',
        };
    }

    public static function generateTrackingCode(): string
    {
        $year = date('Y');
        do {
            $random = strtoupper(str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT));
            $code = "DS-{$year}-{$random}";
        } while (self::where('tracking_code', $code)->exists());
        return $code;
    }
}
