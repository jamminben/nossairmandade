<?php
namespace App\Models;

class LinkSection extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'linksection';
    }

    /**************************
     **    Relationships     **
     **************************/

    public function links()
    {
        return $this->hasMany(Link::class, 'section_id', 'id');
    }
}
