<?php
namespace App\Models;

class MediaSource extends ModelWithTranslations
{
    public $timestamps = false;

    protected $fillable = [

    ];

    public function getHinarioRecordings($hinarioId)
    {
        $hinario = Hinario::where('id', $hinarioId)->first();

        $recordings = [];
        foreach ($hinario->hymns as $hymn) {
            $recordings[] = $hymn->getRecording($this->id);
        }

        return $recordings;
    }
}
