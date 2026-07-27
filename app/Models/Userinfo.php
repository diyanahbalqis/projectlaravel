<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Models\Activity;

class Userinfo extends Model
{

     use HasFactory;

    protected $table = 'userinfo'; 
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'approval',
        'profile_picture',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function activityLog()
{
    return $this->hasMany(\App\Models\ActivityLog::class, 'user_id');
}

public function activityLogs()
{
    return $this->hasMany(ActivityLog::class, 'user_id');
}

public function activities()
{
    return $this->morphMany(Activity::class, 'causer');
}

}
