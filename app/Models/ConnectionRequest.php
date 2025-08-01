<?php

namespace App\Models;

use App\Enums\ConnectionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperConnectionRequest
 */
class ConnectionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];

    protected $casts = [
        'status' => ConnectionStatus::class,
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', ConnectionStatus::Pending);
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', ConnectionStatus::Accepted);
    }

    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', ConnectionStatus::Cancelled);
    }

    public function isPending(): bool
    {
        return $this->status === ConnectionStatus::Pending;
    }

    public function isAccepted(): bool
    {
        return $this->status === ConnectionStatus::Accepted;
    }

    public function isCancelled(): bool
    {
        return $this->status === ConnectionStatus::Cancelled;
    }

    /**
     * Check if users are eligible to connect
     */
    public static function areUsersEligible(User $sender, User $receiver): bool
    {
        // Both users must be active
        if ($sender->isInactive() || $receiver->isInactive()) {
            return false;
        }

        // Users must have attended at least one shared event
        return self::haveSharedEventAttendance($sender, $receiver);
    }

    /**
     * Check if two users have attended the same event
     */
    public static function haveSharedEventAttendance(User $sender, User $receiver): bool
    {
        $senderEventIds = $sender->eventAttendances()->pluck('event_id');
        $receiverEventIds = $receiver->eventAttendances()->pluck('event_id');

        return $senderEventIds->intersect($receiverEventIds)->isNotEmpty() || $receiverEventIds->intersect($senderEventIds)->isNotEmpty();
    }

    /**
     * Get the connection status between two users
     */
    public static function getConnectionStatus(User $sender, User $receiver): ?ConnectionStatus
    {
        $request = self::where(function ($query) use ($sender, $receiver) {
            $query->where('sender_id', $sender->id)
                ->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($sender, $receiver) {
            $query->where('sender_id', $receiver->id)
                ->where('receiver_id', $sender->id);
        })->first();

        return $request?->status;
    }

    /**
     * Check if users are already connected (have accepted connection)
     */
    public static function areUsersConnected(User $sender, User $receiver): bool
    {
        return self::getConnectionStatus($sender, $receiver) === ConnectionStatus::Accepted;
    }

    /**
     * Check if there's a pending request between users
     */
    public static function hasPendingRequest(User $sender, User $receiver): bool
    {
        $request = self::where(function ($query) use ($sender, $receiver) {
            $query->where('sender_id', $sender->id)
                ->where('receiver_id', $receiver->id);
        })->first();

        return $request?->status === ConnectionStatus::Pending;
    }

    /**
     * Create a new connection request
     */
    public static function createRequest(User $sender, User $receiver): ?self
    {
        if (! self::areUsersEligible($sender, $receiver)) {
            return null;
        }

        // Check if there's already a request between these users
        if (self::getConnectionStatus($sender, $receiver) !== null) {
            return null;
        }

        return self::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'status' => ConnectionStatus::Pending,
        ]);
    }

    /**
     * Accept the connection request
     */
    public function accept(): bool
    {
        if (! $this->isPending()) {
            return false;
        }

        return $this->update(['status' => ConnectionStatus::Accepted]);
    }

    /**
     * Cancel the connection request
     */
    public function cancel(): bool
    {
        if (! $this->isPending()) {
            return false;
        }

        return $this->update(['status' => ConnectionStatus::Cancelled]);
    }
}
