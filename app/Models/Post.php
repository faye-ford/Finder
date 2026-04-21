<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination',
        'location',
        'activities',
        'caption',
        'image_path',
        'media',
        'likes_count',
        'share_count',
    ];

    protected $casts = [
        'likes_count' => 'integer',
        'share_count' => 'integer',
        'media' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function managedLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'managed_location_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class)->orderBy('order');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false)->where('is_approved', true);
    }

    public function scopeTrending($query)
    {
        return $query->visible()->orderByDesc('likes_count')->orderByDesc('views_count');
    }

    public function getPrimaryMediaUrlAttribute(): string
    {
        // Check post_images table first
        if ($this->images && $this->images->count() > 0) {
            $firstImage = $this->images->first();
            return asset('storage/' . ltrim($firstImage->image_path, '/'));
        }

        // Fallback to old media array
        if (! empty($this->media) && is_array($this->media) && isset($this->media[0])) {
            $path = $this->media[0];
            return str_starts_with($path, 'http') ? $path : asset('storage/' . ltrim($path, '/'));
        }

        if (! empty($this->image_path)) {
            return str_starts_with($this->image_path, 'http') ? $this->image_path : asset('storage/' . ltrim($this->image_path, '/'));
        }

        return 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80';
    }

    public function getPrimaryMediaTypeAttribute(): string
    {
        // Check if it's a video from media array
        if (! empty($this->media) && is_array($this->media)) {
            $firstMedia = $this->media[0] ?? '';
            $videoExtensions = ['mp4', 'mov', 'webm', 'avi'];
            $ext = pathinfo($firstMedia, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $videoExtensions)) {
                return 'video';
            }
        }
        
        return 'image';
    }
}
