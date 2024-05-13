<?php
namespace App\Models;

class Church extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'church';
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
