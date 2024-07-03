<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HinarioUpdateLog extends Model
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

    public function hinario()
    {
        return $this->hasOne(Hinario::class, 'id', 'hinario_id');
    }
}
