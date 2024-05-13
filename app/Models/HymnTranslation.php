<?php
namespace App\Models;

use App\Classes\Stanza;
use App\Services\GlobalFunctions;
use Illuminate\Database\Eloquent\Model;

class HymnTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    public function getStanzas()
    {
        if (strstr($this->lyrics, "\n")) {
            $lyrics = preg_replace("/(\r?\n){2,}/", "\n\n", $this->lyrics);
            $stanzas = explode("\n\n", $lyrics);
        } else {
            $lyrics = str_replace("\r", "\n", $this->lyrics);
            $lyrics = str_replace("\n \n", "\n\n", $lyrics);
            $stanzas = explode("\n\n", $lyrics);
        }

        $stanzaObjects = [];
        foreach ($stanzas as $stanza) {
            $stanzaObjects[] = new Stanza($stanza);
        }

        return $stanzaObjects;
    }

    /**************************
     **    Relationships     **
     **************************/

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function hymn()
    {
        return $this->hasOne(Hymn::class, 'id', 'hymn_id');
    }
}
