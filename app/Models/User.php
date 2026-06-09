<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'role', 'onboarding_completed', 'voice_id', 'morning_call_time', 'timezone', 'default_delay_minutes', 'last_morning_call_date', 'last_call_time', 'credits', 'google_id', 'avatar', 'calling_preference', 'fcm_token', 'community_participation_mode', 'execution_score', 'community_reputation'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, Billable;

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
            'onboarding_completed' => 'boolean',
            'credits' => 'decimal:2',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function calls(): HasMany
    {
        return $this->hasMany(Call::class);
    }

    public function creditPurchases(): HasMany
    {
        return $this->hasMany(CreditPurchase::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    public function hasSufficientCredits(float $perMinuteRate): bool
    {
        return $this->credits >= $perMinuteRate;
    }

    public function deductCredits(float $amount): void
    {
        $this->decrement('credits', min($amount, $this->credits));
    }

    public function addCredits(float $amount): void
    {
        $this->increment('credits', $amount);
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot(['earned_at', 'is_shared', 'shared_at'])
            ->withTimestamps();
    }

    public function communityPosts(): HasMany
    {
        return $this->hasMany(CommunityPost::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CommunityComment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(CommunityLike::class);
    }

    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    public function following(): HasMany
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function challengeParticipants(): HasMany
    {
        return $this->hasMany(ChallengeParticipant::class);
    }

    public function mentor(): HasOne
    {
        return $this->hasOne(Mentor::class);
    }
}
