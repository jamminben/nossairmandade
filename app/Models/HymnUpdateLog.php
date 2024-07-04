<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HymnUpdateLog extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    public $oldVersion = [];
    public $newVersion = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**************************
     **    Relationships     **
     **************************/

    public function hymn()
    {
        return $this->hasOne(Hymn::class, 'id', 'hymn_id');
    }
}
