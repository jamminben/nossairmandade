<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonAffiliation extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    /**************************
     **    Relationships     **
     **************************/

    public function person()
    {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }

    public function affiliation()
    {
        return $this->hasOne(Affiliation::class, 'id', 'affiliation_id');
    }
}
