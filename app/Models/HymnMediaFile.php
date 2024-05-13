<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HymnMediaFile extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    /**************************
     **    Relationships     **
     **************************/

    public function mediaFile()
    {
        return $this->hasOne(MediaFile::class, 'id', 'media_file_id');
    }

}
