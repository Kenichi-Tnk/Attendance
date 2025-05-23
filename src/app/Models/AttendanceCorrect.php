<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCorrect extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attendance_id',
        'date',
        'clock_in',
        'clock_out',
        'note',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function rests()
    {
        return $this->hasMany(AttendanceCorrectRest::class);
    }
}
