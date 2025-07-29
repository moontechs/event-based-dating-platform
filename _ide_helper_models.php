<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $receiver
 * @property-read \App\Models\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest accepted()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest cancelled()
 * @method static \Database\Factories\ConnectionRequestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectionRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperConnectionRequest {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $extended_description
 * @property string|null $image_path
 * @property \Illuminate\Support\Carbon $date_time
 * @property string $timezone
 * @property int $category_id
 * @property string $city
 * @property string $country
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventAttendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $attendees
 * @property-read int|null $attendees_count
 * @property-read \App\Models\EventCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event draft()
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event future()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event past()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereExtendedDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperEvent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\EventAttendanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperEventAttendance {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory active()
 * @method static \Database\Factories\EventCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperEventCategory {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $used_at
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MagicLink whereUsedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperMagicLink {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $utc_offset
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone active()
 * @method static \Database\Factories\TimeZoneFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereUtcOffset($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTimeZone {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $full_name
 * @property string $whatsapp_number
 * @property string|null $photo_path
 * @property string $relationship_intent
 * @property string $status
 * @property string|null $status_reason
 * @property bool $terms_accepted
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRelationshipIntent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatusReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTermsAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereWhatsappNumber($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

