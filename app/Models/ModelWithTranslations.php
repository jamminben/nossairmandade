<?php
namespace App\Models;

use App\Services\GlobalFunctions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModelWithTranslations extends Model
{
    protected $translation_link_id_field;
    protected $entityName;

    public function getName($languageId = null)
    {
        return $this->getField('name', $languageId);
    }

    public function getDescription($languageId = null)
    {
        return $this->getField('description', $languageId);
    }

    public function getField($fieldName, $languageId = null)
    {
        if (empty($languageId)) {
            $targetLanguage = GlobalFunctions::getCurrentLanguage();
        } else {
            $targetLanguage = $languageId;
        }

        foreach ($this->translations as $translation) {
            if ($translation->language_id == $targetLanguage) {
                return $translation->$fieldName;
            }
        }

        if (count($this->translations) > 0) {
            return $this->translations[0]->$fieldName;
        } else {
            return '';
        }
    }

    public function getTranslation($languageId = null)
    {
        if (empty($languageId)) {
            $targetLanguage = GlobalFunctions::getCurrentLanguage();
        } else {
            $targetLanguage = $languageId;
        }

        foreach ($this->translations as $translation) {
            if ($translation->language_id == $targetLanguage) {
                return $translation;
            }
        }

        return null;
    }

    /**************************
     **    Relationships     **
     **************************/

    public function translations()
    {
        return $this->hasMany(get_class($this) . 'Translation', $this->translation_link_id_field, 'id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'entity_id', 'id')
            ->where('feedback.entity_type', $this->entityName)
            ->orderBy('feedback.resolved', 'ASC')
            ->orderBy('feedback.created_at', 'ASC');
    }

    /**************************
     **    Scopes            **
     **************************/

    public function scopeInLanguage(Builder $query, $languageId)
    {
        return $query->where('language_id', $languageId);
    }
}
