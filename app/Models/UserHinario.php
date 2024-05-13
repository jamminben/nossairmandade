<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class UserHinario extends Hinario
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'hinario';
    }

    public function getName($languageId = null)
    {
        return $this->name;
    }

    public function getDescription($languageId = null)
    {
        return null;
    }

    public function getPreviousHymn($hymnId)
    {
        $currentHymnHinario = UserHymnHinario::where('hinario_id', $this->id)->where('hymn_id', $hymnId)->first();
        $previousHymnHinario = UserHymnHinario::where('hinario_id', $this->id)
            ->where('list_order', '<', $currentHymnHinario->list_order)
            ->orderBy('list_order', 'DESC')
            ->first();
        if (!empty($previousHymnHinario)) {
            return $previousHymnHinario->hymn;
        }

        return null;
    }

    public function getNextHymn($hymnId)
    {
        $currentHymnHinario = UserHymnHinario::where('hinario_id', $this->id)->where('hymn_id', $hymnId)->first();
        $nextHymnHinario = UserHymnHinario::where('hinario_id', $this->id)
            ->where('list_order', '>', $currentHymnHinario->list_order)
            ->orderBy('list_order', 'ASC')
            ->first();
        if (!empty($nextHymnHinario)) {
            return $nextHymnHinario->hymn;
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
                $sources[$recording->source->id] = $recording->source;
                if (isset($counts[$recording->source->id])) {
                    $counts[$recording->source->id] += count($recording->upvotes);
                } else {
                    $counts[$recording->source->id] = count($recording->upvotes);
                }
            }
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
        $name = 'user-hinario/' . $this->code;
        return $name;
    }


    /**************************
     **    Relationships     **
     **************************/

    public function hymns()
    {
        return $this->hasManyThrough(
            Hymn::class,
            UserHymnHinario::class,
            'hinario_id',
            'id',
            'id',
            'hymn_id')
            ->orderBy('user_hymn_hinarios.list_order');
    }

    public function hymnHinarios()
    {
        return $this->hasMany(UserHymnHinario::class, 'hinario_id', 'id')
            ->with('hymn')
            ->orderBy('list_order');
    }
}
