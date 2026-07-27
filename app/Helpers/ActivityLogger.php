<?php

namespace App\Helpers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($action, $subject = null)
    {
        $activity = activity()
            ->causedBy(Auth::user())
            ->performedOn($subject)
            ->log($action);

        // Update extra fields
        $activity->update([
            'user_id' => Auth::id(),
            'action' => $action,
        ]);

        return $activity;
    }
}
