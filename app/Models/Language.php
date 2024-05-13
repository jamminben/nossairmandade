<?php
namespace App\Models;

use App\Services\GlobalFunctions;

class Language extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'language';
    }

    public function getCurrentTranslation()
    {
        foreach ($this->translations as $translation) {
            if ($translation == GlobalFunctions::getCurrentLanguage()) {
                return $translation;
            }
        }
    }

    public function getField($fieldName, $languageId = null)
    {
        if (empty($languageId)) {
            $targetLanguage = GlobalFunctions::getCurrentLanguage();
        } else {
            $targetLanguage = $languageId;
        }

        foreach ($this->translations as $translation) {
            if ($translation->in_language_id == $targetLanguage) {
                return $translation->$fieldName;
            }
        }

        return $this->translations[0]->$fieldName;
    }

    public function getImageSlug()
    {
        if (!empty($this->image)) {
            return 'images/flags/' . $this->image;
        } else {
            return null;
        }
    }
}
