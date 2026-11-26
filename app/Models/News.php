<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'status',
        'published_at',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'views'        => 'integer',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return 'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=800&q=80';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
            if (empty($model->published_at) && $model->status === 'published') {
                $model->published_at = now();
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderBy('published_at', 'desc');
    }
}
