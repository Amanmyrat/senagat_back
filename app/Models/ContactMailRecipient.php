<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMailRecipient extends Model
{
    protected $fillable = [
        'email',
        'is_active',
    ];
}
