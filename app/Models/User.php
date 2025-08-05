<?php

namespace App\Models;

use App\Enums\ConnectionStatus;
use App\Enums\Gender;
use App\Enums\RelationshipIntent;
use App\Enums\SexualPreference;
use App\Enums\UserStatus;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperUser
 */
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'whatsapp_number',
        'relationship_intent',
        'age',
        'gender',
        'sexual_preference',
        'status',
        'status_reason',
        'terms_accepted',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'terms_accepted' => 'boolean',
            'status' => UserStatus::class,
            'relationship_intent' => RelationshipIntent::class,
            'gender' => Gender::class,
            'sexual_preference' => SexualPreference::class,
        ];
    }

    public function acceptedConnectionRequests(): HasMany
    {
        return $this->hasMany(ConnectionRequest::class, 'sender_id')
            ->where('status', ConnectionStatus::Accepted)
            ->orWhere(function ($query) {
                $query->where('receiver_id', $this->id)
                    ->where('status', ConnectionStatus::Accepted);
            });
    }

    public function eventAttendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    public function sentConnectionRequests(): HasMany
    {
        return $this->hasMany(ConnectionRequest::class, 'sender_id');
    }

    public function receivedConnectionRequests(): HasMany
    {
        return $this->hasMany(ConnectionRequest::class, 'receiver_id');
    }

    public function profileImages(): HasMany
    {
        return $this->hasMany(ProfileImage::class);
    }

    public function mainProfileImage(): HasOne
    {
        return $this->hasOne(ProfileImage::class)->where('is_main', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', UserStatus::Active);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', UserStatus::Inactive);
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::Active;
    }

    public function isInactive(): bool
    {
        return $this->status === UserStatus::Inactive;
    }

    public function hasCompletedProfile(): bool
    {
        return ! empty($this->full_name)
            && $this->profileImages()->exists()
            && ! empty($this->whatsapp_number)
            && $this->relationship_intent !== null
            && $this->age !== null
            && $this->gender !== null
            && $this->sexual_preference !== null
            && $this->terms_accepted === true;
    }

    public function getMainProfileImagePath(): ?string
    {
        return $this->mainProfileImage?->image_path;
    }

    public static function generateSecurePassword(): string
    {
        return Str::random(40);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
