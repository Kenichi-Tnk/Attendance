<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

    public function corrects()
    {
        return $this->hasMany(AttendanceCorrect::class);
    }

    public function getRestTimeAttribute()
    {
        $totalRestTime = 0;

        foreach ($this->rests as $rest) {
            if ($rest->rest_start && $rest->rest_end) {
                $start = \Carbon\Carbon::parse($rest->rest_start);
                $end = \Carbon\Carbon::parse($rest->rest_end);
                $totalRestTime += $end->diffInMinutes($start);
            }
        }

        return sprintf('%02d:%02d', intdiv($totalRestTime, 60), $totalRestTime % 60);
    }

    public function getTotalTimeAttribute()
    {
        if ($this->clock_in && $this->clock_out) {
            $clockIn = \Carbon\Carbon::parse($this->clock_in);
            $clockOut = \Carbon\Carbon::parse($this->clock_out);
            $totalTime = $clockOut->diffInMinutes($clockIn) - $this->rest_time_in_minutes;

            return sprintf('%02d:%02d', intdiv($totalTime, 60), $totalTime % 60);
        }

        return '00:00';
    }

    public function getRestTimeInMinutesAttribute()
    {
        $totalRestTime = 0;

        foreach ($this->rests as $rest) {
            if ($rest->rest_start && $rest->rest_end) {
                $start = \Carbon\Carbon::parse($rest->rest_start);
                $end = \Carbon\Carbon::parse($rest->rest_end);
                $totalRestTime += $end->diffInMinutes($start);
            }
        }

        return $totalRestTime;
    }

    public function isPendingApproval()
    {
        return $this->corrects()->where('status', 'pending')->exists();
    }
}
