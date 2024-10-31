<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'attendance_in',
        'attendance_out'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeUserSearch($query)
    {
        $query->where('user_id', Auth::id());
    }
    public function scopeTodaySearch($query)
    {
        $dt = new Carbon();
        $today = $dt->toDateString();

        $query->where('date', $today);
    }
}
