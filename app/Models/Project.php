<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;


class Project extends Model
{
    use HasFactory;
    use MediaAlly;

    protected $fillable = [
        'title',
        'description'
    ];

    public function files()
    {
        return $this->hasOne(File::class);
    }
}
