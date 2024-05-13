<?php
namespace App\Models;

use App\Services\GlobalFunctions;

class UserHymnHinario extends HymnHinario
{
    public $timestamps = false;

    protected $fillable = [];

    /**************************
     **    Relationships     **
     **************************/

    public function hymn()
    {
        return $this->hasOne(Hymn::class, 'id', 'hymn_id')->with('translations');
    }

    public function hinario()
    {
        return $this->hasOne(UserHinario::class, 'id', 'hinario_id');
    }
}
