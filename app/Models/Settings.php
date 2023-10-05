<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Settings extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $table = 'settings';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'company_title',
        'company_email',
        'company_phone',
        'company_address',
        'company_logo',
        'role_id',
        'prefix',
        'developed_by',
        'created_at',
        'updated_at',
    ];


    public function getLogoAttribute()
    {
        $file = $this->getMedia('company_logo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }
}
