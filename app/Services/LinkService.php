<?php
namespace App\Services;

use App\Models\LinkSection;

class LinkService
{
    public function getLinks()
    {
        $linkSections = LinkSection::orderBy('list_order')->get();

        return $linkSections;
    }
}
