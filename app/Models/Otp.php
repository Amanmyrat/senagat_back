<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'code', 'expires_at', 'used', 'phone'];

    protected $dates = ['expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Check for valid and unused OTP
    public function isValid()
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    // Static method to create OTP
    public static function generateForUser($userId, $phone, $length = 5, $minutesValid = 3,)
    {
        $code = '00000';
        //rand(pow(10, $length - 1), pow(10, $length) - 1);

        return self::create([
            'user_id' => $userId,
            'phone' => $phone,
            'code' => $code,
            'expires_at' => now()->addMinutes($minutesValid),
            'used' => false,
        ]);
    }
    public static function generateForPhone($phone, $length = 5, $minutesValid = 3)
    {
        $code = '00000';

        return self::create([
            'phone' => $phone,
            'code' => $code,
            'expires_at' => now()->addMinutes($minutesValid),
            'used' => false,
        ]);
    }


    // Flag when OTP is used
    public function markUsed()
    {
        $this->used = true;
        $this->save();
    }
}
