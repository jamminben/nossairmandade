<?php
namespace App\Models;

use App\Enums\HinarioTypes;
use App\Enums\MediaTypes;
use App\Services\GlobalFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Person extends ModelWithTranslations
{
    const DEFAULT_PORTRAIT_PATH = 'images/persons/0/default.png';

    protected $table = 'persons';

    public $timestamps = false;

    protected $fillable = [];

    public function __construct()
    {
        parent::__construct();
        $this->entityName = 'person';
    }

    public function getPortrait()
    {
        foreach ($this->personImages as $personImage) {
            $imagePath = ltrim($personImage->image->path,'/');
            $filePath = public_path($imagePath);
            $filePath = str_replace('\\', '/', $filePath);
            if (File::exists($filePath)) {
                return $personImage->image->path;
            } else {
                return self::DEFAULT_PORTRAIT_PATH;
            }
            // if ($personImage->is_portrait == 1) {
            //     if (getUrlExists(url($personImage->image->path))) {
            //         return $personImage->image->path;
            //     } else {
            //         return url($personImage->image->path);
            //     }
            // }
        }

        return self::DEFAULT_PORTRAIT_PATH;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        $name = $this->display_name;
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        $name = 'person/' . $this->id .'/' . $name;
        return $name;
    }

    public function getOtherMedia()
    {
        $stackedMedia = [];

        $personMediaFiles = PersonMediaFile::where('person_id', $this->id)->get();
        foreach ($personMediaFiles as $personMediaFile) {
            $stackedMedia[count($personMediaFile->mediaFile->upvotes)][] = $personMediaFile->mediaFile;
        }

        krsort($stackedMedia);

        $media = [];
        foreach (array_keys($stackedMedia) as $count)
        {
            foreach($stackedMedia[$count] as $file) {
                $media[] = $file;
            }
        }

        return $media;
    }

    /**************************
     **    Relationships     **
     **************************/

    public function translations()
    {
        return $this->hasMany(PersonTranslation::class, 'person_id', 'id');
    }

    public function hinarios()
    {
        return $this->hasMany(
            Hinario::class,
            'link_id',
            'id'
            )->where(
                'hinarios.type_id',
                HinarioTypes::INDIVIDUAL
            )->with('translations');
    }

    public function images()
    {
        return $this->hasManyThrough(
            Image::class,
            PersonImage::class,
            'person_id',
            'id',
            'id',
            'image_id');
    }

    public function personImages()
    {
        return $this->hasMany(PersonImage::class, 'person_id', 'id');
    }
}
