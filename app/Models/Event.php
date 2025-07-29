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
}
