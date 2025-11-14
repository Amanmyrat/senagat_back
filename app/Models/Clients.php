<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


/**
 * @property string|null $image_url
 * @method static get()
 */
class Clients extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'company_type', 'description',];
    protected  $fillable =[
      'title','company_type','description','image_url'
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }
}
