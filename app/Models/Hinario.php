<?php
namespace App\Models;

use App\Constants\Constants;
use App\Enums\HinarioTypes;
use App\Enums\MediaTypes;
use App\Services\GlobalFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\HinarioService;


class Hinario extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'hinario';
    }

    public function getOtherMedia()
    {
        $media = [];
        foreach ($this->mediaFiles as $mediaFile) {
            if ($mediaFile->media_type_id != MediaTypes::HINARIO_ZIP) {
                $media[] = $mediaFile;
            }
        }

        return $media;
    }

    public function getPreviousHymn($hymnId)
    {
        $hymnHinarios = HymnHinario::where('hinario_id', $this->id)
            ->orderBy('section_number', 'ASC')
            ->orderBy('list_order', 'ASC')
            ->get();
        for ($x = 0; $x < count($hymnHinarios); $x++) {
            if ($hymnHinarios[$x]->hymn_id == $hymnId && $x > 0) {
                return $hymnHinarios[$x-1]->hymn;
            }
        }

        return null;
    }

    public function getNextHymn($hymnId)
    {
        $hymnHinarios = HymnHinario::where('hinario_id', $this->id)
            ->orderBy('section_number', 'ASC')
            ->orderBy('list_order', 'ASC')
            ->get();
        for ($x = 0; $x < count($hymnHinarios); $x++) {
            if ($hymnHinarios[$x]->hymn_id == $hymnId && $x < count($hymnHinarios) - 1) {
                return $hymnHinarios[$x+1]->hymn;
            }
        }

        return null;
    }

    public function getRecordingSources()
    {
        $counts = [];
        $sources = [];

        foreach ($this->hymns as $hymn) {
            $recordings = $hymn->getRecordings();
            foreach ($recordings as $recording) {
                $recording->source->description = $recording->source->getDescription();
                $sources[$recording->source->id] = $recording->source;
                if (isset($counts[$recording->source->id])) {
                    $counts[$recording->source->id] += count($recording->upvotes);
                } else {
                    $counts[$recording->source->id] = count($recording->upvotes);
                }
            }
        }
        $location = public_path('media/hinarios/');
        if ($this->type_id == HinarioTypes::COMPILATION && file_exists($location . $this->id . '/-1/' .$this->getName($this->original_language_id) .'.zip')) {
            $mixed = MediaSource::where('id', -1)->first();
            $sources[-1] = $mixed;
            $counts[-1] = 10000000;
        }

        asort($counts);

        $finalSources = [];

        foreach (array_keys($counts) as $sourceId) {
            foreach ($sources as $source) {
                if ($source->id == $sourceId) {
                    $finalSources[] = $source;
                }
            }
        }
        return $finalSources;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        $name = $this->getName($this->original_language_id);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        $name = 'hinario/' . $this->id . '/' . $name;
        return $name;
    }

    public function getSections()
    {
        $sections = [];
        foreach ($this->hymnHinarios as $hymnHinario) {
            $sections[$hymnHinario->section_number] = $hymnHinario->getSection();
        }

        ksort($sections);

        return array_values($sections);
    }

    public function getHymnsForSection($sectionNumber)
    {
        $hymnsQuery = Hymn::join('hymn_hinarios', 'hymns.id', '=', 'hymn_hinarios.hymn_id')
            ->where('hymn_hinarios.hinario_id', '=', $this->id)
            ->select('hymns.*')
            ->with('notationTranslations', 'translations', 'hymnHinarios')
            ->orderBy('hymn_hinarios.list_order');

        if ($sectionNumber != 0) {
            $hymnsQuery->where('hymn_hinarios.section_number', '=', $sectionNumber);
        }

        $hymns = $hymnsQuery->get();

        return $hymns;
    }

    public function hasTranslationsForLanguage($language_id)
    {
        $totalHymns = count($this->hymns);
        $translatedHymns = 0;
        foreach ($this->hymns as $hymn) {
            if (!empty($hymn->getTranslation($language_id))) {
                $translatedHymns++;
            }
        }

        if ($translatedHymns == $totalHymns) {
            return true;
        } else {
            return false;
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

    public function displaySections()
    {
        return count($this->sections) > 1;
    }



    /**************************
     **    Relationships     **
     **************************/

    public function hymns()
    {
        return $this->hasManyThrough(
            Hymn::class,
            HymnHinario::class,
            'hinario_id',
            'id',
            'id',
            'hymn_id')
            ->orderBy('hymn_hinarios.list_order');
    }

    public function sections()
    {
        return $this->hasMany(HinarioSection::class, 'hinario_id', 'id')->orderBy('section_number');
    }

    public function hymnHinarios()
    {
        return $this->hasMany(HymnHinario::class, 'hinario_id', 'id')
            ->with('hymn', 'section')
            ->orderBy('section_number')
            ->orderBy('list_order');
    }

    public function media()
    {
        return $this->hasManyThrough(
            MediaFile::class,
            HinarioMediaFile::class,
            'hinario_id',
            'id',
            'id',
            'media_file_id');
    }

    public function church()
    {
        return $this->hasOne(Church::class, 'id', 'link_id');
    }

    public function mediaFiles()
    {
        return $this->hasManyThrough(
            MediaFile::class,
            HinarioMediaFile::class,
            'hinario_id',
            'id',
            'id',
            'media_file_id')
            ->with('source');
    }

    public function receivedBy()
    {
        if ($this->type_id == Constants::HINARIO_TYPE_INDIVIDUAL) {
            return $this->hasOne(Person::class, 'id', 'link_id')
                ->with('translations', 'images', 'hinarios', 'personImages');
        } elseif ($this->type_id = Constants::HINARIO_TYPE_LOCAL) {
            return $this->hasOneThrough(
                Person::class,
                PersonLocalHinario::class,
                'hinario_id',
                'id',
                'id',
                'person_id')
                ->with('translations', 'images', 'hinarios', 'personImages');
        }
    }

    public function personLocalHinario()
    {
        return $this->hasOne(PersonLocalHinario::class, 'hinario_id', 'id');
    }

    public function getHinarioName() {
        return json_decode($this->preloaded_json)->name;
    }
}
