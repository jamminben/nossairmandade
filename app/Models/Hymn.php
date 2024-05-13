<?php
namespace App\Models;

use App\Enums\EntityTypes;
use App\Enums\MediaTypes;
use App\Services\GlobalFunctions;
use App\Services\GlobalService;
use Illuminate\Database\Eloquent\Model;

class Hymn extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'hymn';
    }

    public function getName($languageId = null)
    {
        $name = parent::getName($languageId);
        return mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
    }

    public function hasMediaLinks()
    {
        return false;
    }

    public function getNotation($languageId = null)
    {
        if (empty($languageId)) {
            $languageId = GlobalFunctions::getCurrentLanguage();
        }

        foreach ($this->notationTranslations as $notationTranslation) {
            if ($notationTranslation->language_id == $languageId) {
                return $notationTranslation->name;
            }
        }

        if (count($this->notationTranslations) > 0) {
            return $this->notationTranslations[0]->name;
        }

        return '';
    }

    public function getNumber($hinarioId)
    {
        foreach ($this->hymnHinarios as $hymnHinario) {
            if ($hymnHinario->hinario_id == $hinarioId) {
                return $hymnHinario->list_order;
            }
        }

        return 0;
    }

    public function getNumberUserHinario($userHinarioId)
    {
        $hymnHinario = UserHymnHinario::where('hinario_id', $userHinarioId)->where('hymn_id', $this->id)->first();
        return $hymnHinario->list_order;
    }

    public function getSlug()
    {
        $name = $this->getName($this->original_language_id);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        $name = '/hymn/' . $this->id . '/' . $name;
        return $name;
    }

    public function getOriginalHinarioId()
    {
        foreach ($this->hymnHinarios as $hymnHinario) {
            if ($hymnHinario->original_hinario == 1) {
                return $hymnHinario->hinario_id;
            }
        }
    }

    public function getPrimaryTranslation()
    {
        foreach ($this->translations as $translation) {
            if ($translation->language_id == $this->original_language_id) {
                return $translation;
            }
        }
    }

    public function getSecondaryTranslations()
    {
        $translations = [];
        foreach ($this->translations as $translation) {
            if ($translation->language_id != $this->original_language_id) {
                if ($translation->language_id == GlobalFunctions::getCurrentLanguage()) {
                    array_unshift($translations, $translation);
                } else {
                    array_push($translations, $translation);
                }
            }
        }
        return $translations;
    }

    public function getTranslation($languageId = null)
    {
        if (empty($languageId)) {
            $languageId = $this->original_language_id;
        }

        foreach ($this->translations as $translation) {
            if ($translation->language_id == $languageId) {
                return $translation;
            }
        }

        return null;
    }

    public function stanzas($languageId = null)
    {
        if (empty($languageId)) {
            $languageId = $this->original_language_id;
        }

        foreach ($this->translations as $translation) {
            if ($translation->language_id == $languageId) {
                return $translation->getStanzas();
            }
        }

        return [];
    }

    public function getHinarios()
    {
        $allHinarios = $this->hinarios;

        $hinarios = [];
        foreach ($allHinarios as $hinario) {
            if ($hinario->id == GlobalFunctions::getActiveHinario()) {
                array_unshift($hinarios, $hinario);
            } else {
                array_push($hinarios, $hinario);
            }
        }

        return $hinarios;
    }

    public function getRecordings()
    {
        $stackedRecordings = [];

        foreach ($this->mediaFiles as $mediaFile) {
            if ($mediaFile->media_type_id == MediaTypes::AUDIO) {
                $stackedRecordings[count($mediaFile->upvotes)][] = $mediaFile;
            }
        }

        krsort($stackedRecordings);

        $recordings = [];
        foreach (array_keys($stackedRecordings) as $count)
        {
            foreach($stackedRecordings[$count] as $recording) {
                $recordings[] = $recording;
            }
        }

        return $recordings;
    }

    public function getOtherMedia()
    {
        $stackedMedia = [];

        foreach ($this->mediaFiles as $mediaFile) {
            if ($mediaFile->media_type_id != MediaTypes::AUDIO) {
                $stackedMedia[count($mediaFile->upvotes)][] = $mediaFile;
            }
        }

        krsort($stackedMedia);

        $media = [];
        foreach (array_keys($stackedMedia) as $count)
        {
            foreach($stackedMedia[$count] as $file) {
                $media[] = $file;
            }
        }

        return $media;
    }

    public function getRecording($sourceId)
    {
        if ($sourceId >= 0) {
            foreach ($this->mediaFiles as $mediaFile) {
                if ($mediaFile->media_source_id == $sourceId && $mediaFile->media_type_id == MediaTypes::AUDIO) {
                    return $mediaFile;
                }
            }
        } else {
            $stackedRecordings = [];
            foreach ($this->mediaFiles as $mediaFile) {
                if ($mediaFile->media_type_id == MediaTypes::AUDIO) {
                    $stackedRecordings[count($mediaFile->upvotes)][] = $mediaFile;
                }
            }

            if (count($stackedRecordings) == 0) {
                return null;
            }

            krsort($stackedRecordings);

            $recordings = [];
            foreach (array_keys($stackedRecordings) as $count)
            {
                foreach($stackedRecordings[$count] as $recording) {
                    $recordings[] = $recording;
                }
            }

            return $recordings[0];
        }

        return null;
    }

    /**************************
     **    Relationships     **
     **************************/

    public function receivedBy()
    {
        return $this->hasOne(Person::class, 'id', 'received_by');
    }

    public function offeredTo()
    {
        return $this->hasOne(Person::class, 'id', 'offered_to');
    }

    public function receivedHinario()
    {
        return $this->hasOne(Hinario::class, 'id', 'received_hinario_id');
    }

    public function mediaFiles()
    {
        return $this->hasManyThrough(
            MediaFile::class,
            HymnMediaFile::class,
            'hymn_id',
            'id',
            'id',
            'media_file_id')
            ->with('upvotes', 'source');
    }

    public function hinarios()
    {
        return $this->hasManyThrough(
            Hinario::class,
            HymnHinario::class,
            'hymn_id',
            'id',
            'id',
            'hinario_id');
    }

    public function hymnHinarios()
    {
        return $this->hasMany(
            HymnHinario::class, 'hymn_id', 'id'
        );
    }

    public function notationTranslations()
    {
        return $this->hasMany(HymnNotationTranslation::class, 'hymn_notation_id', 'notation');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'entity_id', 'id')
            ->where('feedback.entity_type', EntityTypes::HYMN)
            ->orderBy('feedback.resolved', 'ASC')
            ->orderBy('feedback.created_at', 'ASC');
    }
}
