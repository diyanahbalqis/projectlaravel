<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;


class ActivityLog extends SpatieActivity
{
    // If  changed the table name
    protected $table = 'activity_log';

   
    protected $fillable = [
        'user_id',
        'log_name',
        'staff_id',
        'action',
        'description',
        'causer_id',
        'causer_type',
        'subject_id',
        'subject_type',
        'properties',
        'Updated_at',
        'created_at',
    ];

    // Cast properties JSON
    protected $casts = [
        'properties' => 'array',
    ];

    // Optional: relationships

    // User who performed the action (redundant to causer, but easier)
    public function users()
{
    return $this->belongsTo(User::class, 'user_id');
}


    // The affected model
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    // Causer (Spatie default)
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

   
}
