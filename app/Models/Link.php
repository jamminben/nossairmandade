<?php
namespace App\Models;

class Link extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'link';
    }

    public function linkSection()
    {
        return $this->hasOne(LinkSection::class, 'id', 'section_id');
    }
}
