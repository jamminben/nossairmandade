<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicianMediaFile extends Model
{
    public $timestamps = false;

    protected $fillable = [

    ];

    public function mediaFile()
    {
        return $this->hasOne(MediaFile::class, 'id', 'media_file_id');
    }
}
