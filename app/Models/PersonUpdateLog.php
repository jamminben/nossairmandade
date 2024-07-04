<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonUpdateLog extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**************************
     **    Relationships     **
     **************************/

    public function person()
    {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }
}
