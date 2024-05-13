<?php
namespace App\Services;


use App\Models\Hymn;

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
}