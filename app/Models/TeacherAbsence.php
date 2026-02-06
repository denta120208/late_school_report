<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAbsence extends Model
{
    protected $fillable = [
        'recorded_by',
        'absence_date',
        'teacher_name',
        'reason',
    ];

    protected $casts = [
        'absence_date' => 'date',
    ];

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('absence_date', $date);
    }
}
