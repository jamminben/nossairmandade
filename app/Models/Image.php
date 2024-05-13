<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    public function getSlug()
    {
        return url($this->path);
    }


}
