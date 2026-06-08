<?php

namespace App\Services;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log a user activity to the database if enabled.
     *
     * @param string $activity
     * @param string $description
     * @param mixed|null $user
     * @return void
     */
    public static function log(string $activity, string $description, $user = null): void
    {
        if (!config('activity.log_user_activities', true)) {
            return;
        }

        $userId = null;
        $userType = null;

        if ($user) {
            if (is_object($user) && method_exists($user, 'getKey')) {
                $userId = $user->getKey();
                $userType = get_class($user);
            } elseif (is_numeric($user)) {
                $userId = (int) $user;
                // Default to active auth user class or standard User class
                $userType = Auth::check() ? get_class(Auth::user()) : \App\Models\User::class;
            }
        } else {
            // Auto detect active authenticated user (User or Admin)
            $activeUser = Auth::user();
            if ($activeUser) {
                $userId = $activeUser->getKey();
                $userType = get_class($activeUser);
            }
        }

        UserActivity::create([
            'user_id' => $userId,
            'user_type' => $userType,
            'activity' => $activity,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
