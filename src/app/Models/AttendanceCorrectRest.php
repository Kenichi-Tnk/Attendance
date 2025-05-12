<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceCorrectRest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_correct_id',
        'rest_start',
        'rest_end',
    ];

    public function attendanceCorrect()
    {
        return $this->belongsTo(AttendanceCorrect::class);
    }
}
