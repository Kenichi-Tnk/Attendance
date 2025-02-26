<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'data',
        'clock_in',
        'clock_out',
        'status',
    ];

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }
}
