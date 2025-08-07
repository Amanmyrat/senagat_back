<?php
namespace App\Services;

use App\Models\User;

class CheckService
{

    public function checkPhoneExists(string $phone): bool
    {

        return User::where('phone', $phone)->exists();

    }
}
