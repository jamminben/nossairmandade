<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonImage extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    /**************************
     **    Relationships     **
     **************************/

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function person()
    {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }
}
