<?php
namespace App\Models;

use App\Services\GlobalFunctions;

class Carousel extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'carousel';
    }

    public function getImageSlug()
    {
        return url('images/carousel/' . $this->image);
    }

    public function getLinkUrl()
    {
        if (!empty($this->link_url)) {
            return url($this->link_url);
        } else {
            return url('/');
        }
    }

    public function getButtonText($languageId = null)
    {
        if (empty($languageId)) {
            $targetLanguage = GlobalFunctions::getCurrentLanguage();
        } else {
            $targetLanguage = $languageId;
        }

        foreach ($this->translations as $translation) {
            if ($translation->language_id == $targetLanguage) {
                return $translation->button_text;
            }
        }

        if (count($this->translations) > 0) {
            return $this->translations[0]->button_text;
        } else {
            return '';
        }
    }
}
