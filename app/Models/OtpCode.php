<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    use HasFactory;

    protected $table = 'otps';

    protected $fillable = ['code', 'expires_at', 'phone'];

    protected $dates = ['expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Static method to create OTP
    public static function generateForUser( $phone, $length = 5, $minutesValid = 3)
    {
        $code = '00000';
        // rand(pow(10, $length - 1), pow(10, $length) - 1);

        return self::create([
            'phone' => $phone,
            'code' => $code,
            'expires_at' => now()->addMinutes($minutesValid),
        ]);
    }

    public static function generateForPhone($phone, $length = 5, $minutesValid = 3)
    {
        $code = '00000';

        return self::create([
            'phone' => $phone,
            'code' => $code,
            'expires_at' => now()->addMinutes($minutesValid),
        ]);
    }
}
