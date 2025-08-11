<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Location extends Model
{
    use HasTranslations;

    public $translatable = ['name','address',];

    protected $fillable =['type','name','address','location'];
    protected $casts = [
               'location' => 'array',

    ];

}
