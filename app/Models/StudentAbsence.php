<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAbsence extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'recorded_by',
        'absence_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'absence_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('absence_date', $date);
    }
}
