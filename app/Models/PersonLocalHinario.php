<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonLocalHinario extends Model
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

    public function hinario()
    {
        return $this->hasOne(Hinario::class, 'id', 'hinario_id');
    }
}
