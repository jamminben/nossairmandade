<?php
namespace App\Services;


use App\Constants\Constants;
use App\Models\Hymn;
use App\Models\HymnHinario;
use App\Models\HymnTranslation;

class HymnService
{
    /**
     * @param $hymnId
     * @return Hymn
     */
    public function getHymn($hymnId)
    {
        $hymn = Hymn::where('id', $hymnId)->first();

        return $hymn;
    }

    public function makeNewHymn($hinario, $hymnHinario, $section=null)
    {
        $hymn = new Hymn();
        $hymn->original_language_id = $hinario->original_language_id;
        if ($hinario->type == Constants::HINARIO_TYPE_INDIVIDUAL) {
            $hymn->received_by = $hinario->link_id;
        } else {
            $hymn->received_by = 0;
        }
        $hymn->save();

        $hymnTranslation = new HymnTranslation();
        $hymnTranslation->language_id = $hinario->original_language_id;
        $hymnTranslation->name = 'New Hymn';
        $hymnTranslation->hymn_id = $hymn->id;
        $hymnTranslation->save();

        $newHymnHinario = new HymnHinario();
        $newHymnHinario->hymn_id = $hymn->id;
        $newHymnHinario->hinario_id = $hinario->id;
        if (is_null($section)) {
            $newHymnHinario->section_number = $hymnHinario->section_number;
            $newHymnHinario->list_order = $hymnHinario->list_order + 1;
        } else {
            $newHymnHinario->section_number = $section;
            $hymnsInSection = $hinario->getHymnsForSection($section);
            $newHymnHinario->list_order = count($hymnsInSection) + 1;
        }

        $newHymnHinario->save();

        return $newHymnHinario;
    }
}
