<?php
namespace App\Services;

use App\Models\HymnNotation;

class NotationService
{
    public function getNotationsForDisplay()
    {
        $notations = HymnNotation::where('display_flag', 1)->orderBy('display_order', 'asc')->get();

        return $notations;
    }
}
