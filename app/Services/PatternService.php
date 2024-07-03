<?php
namespace App\Services;

use App\Models\HymnPattern;

class PatternService
{
    public function getPatternsForDisplay()
    {
        $patterns = HymnPattern::where('display_flag', 1)->orderBy('display_order')->get();

        return $patterns;
    }
}
