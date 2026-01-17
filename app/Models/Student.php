<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'student_number',
        'class_id',
        'gender',
        'address',
        'phone',
        'parent_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function lateAttendances()
    {
        return $this->hasMany(LateAttendance::class, 'student_id');
    }

    // Helper methods
    public function getTotalLateCount()
    {
        return $this->lateAttendances()->count();
    }

    public function getLateStatus()
    {
        $count = $this->getTotalLateCount();
        
        if ($count >= 5) {
            return 'parent_notification';
        } elseif ($count >= 3) {
            return 'warning';
        }
        
        return 'normal';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
