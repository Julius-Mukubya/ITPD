<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SessionParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'counseling_session_id',
        'name',
        'email',
        'status',
        'invitation_token',
        'invited_at',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    /**
     * Generate a unique invitation token
     */
    public static function generateInvitationToken(): string
    {
        do {
            $token = Str::random(32);
        } while (self::where('invitation_token', $token)->exists());

        return $token;
    }

    /**
     * Get the counseling session that owns the participant
     */
    public function counselingSession()
    {
        return $this->belongsTo(CounselingSession::class);
    }

    /**
     * Mark participant as joined
     */
    public function markAsJoined()
    {
        $this->update([
            'status' => 'joined',
            'joined_at' => now(),
        ]);
    }

    /**
     * Mark participant as declined
     */
    public function markAsDeclined()
    {
        $this->update([
            'status' => 'declined',
        ]);
    }

    /**
     * Mark participant as left
     */
    public function markAsLeft()
    {
        $this->update([
            'status' => 'left',
            'left_at' => now(),
        ]);
    }

    /**
     * Check if participant has joined
     */
    public function hasJoined(): bool
    {
        return $this->status === 'joined';
    }

    /**
     * Check if participant has declined
     */
    public function hasDeclined(): bool
    {
        return $this->status === 'declined';
    }

    /**
     * Check if participant has left
     */
    public function hasLeft(): bool
    {
        return $this->status === 'left';
    }

    /**
     * Get the invitation URL
     */
    public function getInvitationUrl(): string
    {
        return route('counseling.group.join', [
            'token' => $this->invitation_token,
            'session' => $this->counseling_session_id,
        ]);
    }
}