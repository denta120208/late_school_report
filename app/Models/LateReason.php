<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LateReason extends Model
{
    protected $fillable = [
        'reason',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function lateAttendances()
    {
        return $this->hasMany(LateAttendance::class, 'late_reason_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
