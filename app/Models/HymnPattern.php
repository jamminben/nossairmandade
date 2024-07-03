<?php
namespace App\Models;

use App\Classes\Stanza;
use App\Services\GlobalFunctions;

class HymnPattern extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function getSampleText()
    {
        $translation = HymnPatternTranslation::where('hymn_pattern_id', $this->pattern_id)->where('language_id', GlobalFunctions::getCurrentLanguage())->first();

        if (is_null($translation)) {
            $text = '';
        } else {
            $text = $translation->hymn_text;
        }

        if (strstr($text, "\n")) {
            $lyrics = preg_replace("/(\r?\n){2,}/", "\n\n", $text);
            $stanzas = explode("\n\n", $lyrics);
        } else {
            $lyrics = str_replace("\r", "\n", $text);
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
}
