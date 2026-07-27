<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'users';
    protected $fillable = [
    'name',
    'staff_id',
    'email',
    'password',
    'role',
    'phone',
    'address',
    'approval',
    'profile_picture',
    'department',
    ];

//     public function getAuthIdentifierName()
// {
//     return 'staff_id';
// }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }
    
    public function roles()
{
    return $this->belongsTo(Role::class);
}


// public function loans()
//     {
//         return $this->hasMany(Loan::class, 'user_id');
//     }

    public function loans()
{
    return $this->hasMany(Loan::class);
}

public function activityLogs()
{
    return $this->hasMany(ActivityLog::class, 'id');
}

public function activities()
{
    return $this->morphMany(Activity::class, 'causer');
}

public function activityLog()
{
    return $this->hasMany(\App\Models\ActivityLog::class, 'id');
}

 public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id');
}

}
