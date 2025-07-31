<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @mixin IdeHelperEvent
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'extended_description',
        'image_path',
        'date_time',
        'timezone',
        'category_id',
        'city',
        'country',
        'is_published',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    public function attendees(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, EventAttendance::class, 'event_id', 'id', 'id', 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    public function scopeFuture($query)
    {
        return $query->where('date_time', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('date_time', '<', now());
    }

    public function scopeByCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }

        return $query;
    }

    public function scopeByLocation($query, $city = null, $country = null)
    {
        if ($city) {
            $query->where('city', 'ILIKE', "%{$city}%");
        }
        if ($country) {
            $query->where('country', 'ILIKE', "%{$country}%");
        }

        return $query;
    }

    public function scopeByDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->where('date_time', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('date_time', '<=', $endDate);
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                    ->orWhere('description', 'ILIKE', "%{$search}%")
                    ->orWhere('extended_description', 'ILIKE', "%{$search}%")
                    ->orWhere('city', 'ILIKE', "%{$search}%")
                    ->orWhere('country', 'ILIKE', "%{$search}%");
            });
        }

        return $query;
    }

    public function canMarkAttendance(): bool
    {
        // Current and future events: unrestricted
        if ($this->date_time >= now()) {
            return true;
        }

        // Past events: up to 2 days old
        return $this->date_time >= now()->subDays(2);
    }

    public function isUserAttending(?int $userId = null): bool
    {
        if (! $userId) {
            $userId = auth()->id();
        }

        if (! $userId) {
            return false;
        }

        return $this->attendances()->where('user_id', $userId)->exists();
    }

    public function getAttendeesCountAttribute(): int
    {
        return $this->attendances()->count();
    }
}
