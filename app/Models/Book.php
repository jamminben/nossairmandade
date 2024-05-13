<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'book';
    }

    public function getTitle($languageId = null)
    {
        return $this->getField('title', $languageId);
    }

    public function getImageUrl()
    {
        return url('/images/books/' . $this->id . '/' . $this->image);
    }
}
