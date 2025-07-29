<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperMagicLink
 */
class MagicLink extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'used_at',
        'created_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public static function generateToken(): string
    {
        return Str::random(60);
    }

    public static function generateCode(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public static function createForEmail(string $email, int $expirationMinutes = 15): self
    {
        // Use 6-digit code as the token for both verification methods
        return self::create([
            'email' => $email,
            'token' => self::generateCode(),
            'expires_at' => Carbon::now()->addMinutes($expirationMinutes),
            'created_at' => Carbon::now(),
        ]);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }

    public function isValid(): bool
    {
        return ! $this->isExpired() && ! $this->isUsed();
    }

    public function markAsUsed(): void
    {
        $this->update(['used_at' => Carbon::now()]);
    }

    public static function findValidToken(string $email, string $token): ?self
    {
        return self::where('email', $email)
            ->where('token', $token)
            ->whereNull('used_at')
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }

    public static function cleanupExpired(): int
    {
        return self::where('expires_at', '<', Carbon::now()->subDay())->delete();
    }
}
