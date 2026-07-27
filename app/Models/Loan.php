<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_id',
        'name',
        'phone',
        'department',
        'email',
        
        // Loan Details
        'purpose',
        'other_purpose',
        'item_type',
        'item',
        'other_equipment',
        'asset_no',
        'quantity',
        'serial_no',
        'equipment_id',
        
        // Equipment Details
        'current_location',
        'asset_serial_number',
        'model',
        'additional_description',
        'condition',
        
        // Dates
        'date_borrow',
        'date_return',
        'est_ret_date',
        
        // Signatures & Approvals
        'name_borrower',
        'date_borrower',
        'sign_borrower',
        'stamp_borrower',
        
        'name_superior',
        'date_superior',
        'sign_superior',
        
        'name_ict',
        'date_ict',
        'sign_ict',
        
        // Status
        'status',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'date_borrow' => 'date',
        'date_return' => 'date',
        'est_ret_date' => 'date',
        'date_borrower' => 'date',
        'date_superior' => 'date',
        'date_ict' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    protected static function booted()
    {
        // When a loan is created
        static::created(function ($loan) {
            if ($loan->equipment_id) {
                Equipment::where('id', $loan->equipment_id)
                    ->update([
                        'status' => 'Not Available',
                        'user_id' => $loan->user_id
                    ]);
            }
        });

        // When a loan is updated
        static::updated(function ($loan) {
            if ($loan->equipment_id) {
                // If returned (has return date and status is Returned)
                if ($loan->date_return && $loan->status === 'Returned') {
                    Equipment::where('id', $loan->equipment_id)
                        ->update([
                            'status' => 'Available',
                            'user_id' => null
                        ]);
                }
                // If rejected
                elseif ($loan->status === 'Rejected') {
                    Equipment::where('id', $loan->equipment_id)
                        ->update([
                            'status' => 'Available',
                            'user_id' => null
                        ]);
                }
            }
        });

        // When a loan is deleted
        static::deleted(function ($loan) {
            if ($loan->equipment_id) {
                Equipment::where('id', $loan->equipment_id)
                    ->update([
                        'status' => 'Available',
                        'user_id' => null
                    ]);
            }
        });
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Loan belongs to equipment
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Check if loan is pending
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['Pending', 'Approved']);
    }
    /**
     * Check if loan is approved
     */
    public function isApproved()
    {
        return $this->status === 'Approved';
    }

    /**
     * Check if loan is returned
     */
    public function isReturned()
    {
        return $this->status === 'Returned';
    }

    /**
     * Check if loan is overdue
     */
    public function isOverdue()
    {
        return $this->est_ret_date && 
               $this->est_ret_date < now() && 
               $this->status !== 'Returned';
    }

    /**
     * Scope: Get only pending loans
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope: Get only approved loans
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    /**
     * Scope: Get overdue loans
     */
    public function scopeOverdue($query)
    {
        return $query->where('est_ret_date', '<', now())
                     ->where('status', '!=', 'Returned');
    }
}
