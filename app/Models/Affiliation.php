<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'affiliation';
    }


    /**************************
     **    Relationships     **
     **************************/

    public function people()
    {
        return $this->hasManyThrough(
            Person::class,
            PersonAffiliation::class,
            'affiliation_id',
            'id',
            'id',
            'person_id')
            ->orderBy('persons.display_name');
    }
}
