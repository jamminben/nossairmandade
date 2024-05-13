<?php
namespace App\Models;

class MediaFile extends ModelWithTranslations
{
    public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [

    // ];

    public function hasUpvote($userId)
    {
        $upvote = MediaFileUpvote::where('media_file_id', $this->id)
            ->where('user_id', $userId)
            ->first();

        if (empty($upvote)) {
            return false;
        } else {
            return true;
        }
    }

    public function getOtherUpvotesCount($userId)
    {
        $count = MediaFileUpvote::where('media_file_id', $this->id)
            ->where('user_id', '!=', $userId)
            ->count();

        return $count;
    }


    /**************************
     **    Relationships     **
     **************************/

    public function upvotes()
    {
        return $this->hasMany(MediaFileUpvote::class, 'media_file_id', 'id');
    }

    public function source()
    {
        return $this->hasOne(MediaSource::class, 'id', 'media_source_id')->with('translations');
    }
}
