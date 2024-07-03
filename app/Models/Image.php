<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function getSlug()
    {
        return url($this->path);
    }

    public function getPrimaryTranslation()
    {
        return ImageTranslation::where('image_id', $this->id)->orderBy('id', 'DESC')->first();
    }

    public function getSecondaryTranslations()
    {
        $primary = $this->getPrimaryTranslation();

        if (empty($primary)) {
            return null;
        }
        return ImageTranslation::where('image_id', $this->id)
            ->where('id', '!=', $primary->id)
            ->orderBy('id', 'DESC')
            ->get();
    }

}
