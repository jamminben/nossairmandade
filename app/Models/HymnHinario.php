<?php
namespace App\Models;

use App\Services\GlobalFunctions;
use Illuminate\Database\Eloquent\Model;

class HymnHinario extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    private $loadedSection = null;

    public function getSection()
    {
        $section = HinarioSection::where('hinario_id', $this->hinario_id)->where('section_number', $this->section_number)->first();

        if (empty($section)) {
            $section = new HinarioSection();
            $sectionTranslation = new HinarioSectionTranslation();
            $sectionTranslation->name = $this->hinario->getName($this->hinario->original_language_id);
            $sectionTranslation->languageId = GlobalFunctions::getCurrentLanguage();
            $section->translations = collect([$sectionTranslation]);
            $section->hinario_id = $this->hinario->id;
        }

        return $section;
    }

    /**************************
     **    Relationships     **
     **************************/

    public function hymn()
    {
        return $this->hasOne(Hymn::class, 'id', 'hymn_id')->with('translations');
    }

    public function hinario()
    {
        return $this->hasOne(Hinario::class, 'id', 'hinario_id')->with('translations');
    }

    public function section()
    {
        $dingus = $this->hasOne(HinarioSection::class, 'hinario_id', 'hinario_id')
            ->where('hinario_sections.section_number', 'hymn_hinarios.section_number')
            ->with('translations');

        return $dingus;
    }
}
