<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'work_start',
        'work_end', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class, 'work_id');
    }
    // 日付とユーザーIDに基づいて勤務情報を取得するスコープ
    public function scopeDateAndUserId($query, $date, $userId)
    {
        return $query->whereDate('date', $date)->where('user_id', $userId);
    }
}
