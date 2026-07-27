<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'item_type',
        'asset_no',
        'serial_no',
        'model',
        'current_location',
        'status', 
        'description', 
        'user_id'
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Get the current loan for this equipment (if any)
     */
    public function currentLoan()
    {
        return $this->hasOne(Loan::class)
            ->whereIn('status', ['Pending', 'Approved'])
            ->latest();
    }

    /**
     * Check if equipment is available
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    /**
     * Check if equipment is on loan
     */
   

    /**
     * Scope: Get only available equipment
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 'Not Available');
    }

    public function markAsAvailable()
    {
        $this->update([
            'status' => 'Available',
            'user_id' => null
        ]);
    }
    /**
     * Scope: Get only equipment on loan
     */
    public function markAsNotAvailable($userId)
    {
        $this->update([
            'status' => 'Not Available',
            'user_id' => $userId
        ]);
    }
}


