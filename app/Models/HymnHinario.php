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
        if (empty($this->loadedSection)) {
            /*$section = HinarioSection::where('hinario_id', $this->hinario_id)
                ->where('section_number', $this->section_number)
                ->with('translations')
                ->first();*/
            $section = $this->section;

            if (empty($section)) {
                $section = new HinarioSection();
                $sectionTranslation = new HinarioSectionTranslation();
                $sectionTranslation->name = $this->hinario->getName($this->hinario->original_language_id);
                $sectionTranslation->languageId = GlobalFunctions::getCurrentLanguage();
                $section->translations = collect([$sectionTranslation]);
                $section->hinario_id = $this->hinario->id;
            }

            $this->loadedSection = $section;
        } else {
            $section = $this->loadedSection;
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
        return $this->hasOne(HinarioSection::class, 'hinario_id', $this->hinario_id)
            ->where('section_number', $this->section_number)
            ->with('translations');
    }
}
