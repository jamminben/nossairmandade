<?php
namespace App\Models;

use App\Services\GlobalFunctions;
use Illuminate\Database\Eloquent\Model;

class HinarioSection extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'hinariosection';
    }

    /**************************
     **    Relationships     **
     **************************/

    public function hinario()
    {
        return $this->hasOne(Hinario::class, 'id', 'hinario_id');
    }
}
