<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;

class CampaignPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'teacher', 'counselor']);
    }

    public function view(User $user, Campaign $campaign)
    {
        return $user->isAdmin() || $campaign->created_by === $user->id;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'teacher', 'counselor']);
    }

    public function update(User $user, Campaign $campaign)
    {
        return $user->isAdmin() || $campaign->created_by === $user->id;
    }

    public function delete(User $user, Campaign $campaign)
    {
        return $user->isAdmin() || $campaign->created_by === $user->id;
    }
}
