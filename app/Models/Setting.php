<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';

    protected $fillable = [
        'name',
        'email',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true; // tukar ke true kalau table has created_at/updated_at


    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}