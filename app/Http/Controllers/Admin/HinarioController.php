<?php
namespace App\Http\Controllers\Admin;

use App\Enums\HinarioTypes;
use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Hinario;
use App\Models\Hymn;
use App\Models\HymnHinario;
use App\Models\HymnNotationTranslation;
use App\Models\HymnTranslation;
use App\Models\LanguageTranslation;
use App\Models\Person;
use App\Models\PersonTranslation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class HinarioController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function preloadHinario($hinarioId)
    {
        $hinarioModel = Hinario::where('id', $hinarioId)
            ->with('translations', 'sections', 'hymns', 'hymnHinarios', 'hymnHinarios.hinario', 'receivedBy', 'hymns.mediaFiles', 'hymns.translations', 'hymns.hymnHinarios')
            ->first();

        $recordingSourceModels = $hinarioModel->getRecordingSources();

        $recordingSourceArray = [];
        foreach ($recordingSourceModels as $recordingSourceModel) {
            $recordingSourceArray[] = [
                'id' => $recordingSourceModel->id,
                'description' => $recordingSourceModel->getDescription()
            ];
        }

        $otherMediaModels = $hinarioModel->getOtherMedia();

        $otherMediaArray = [];
        foreach ($otherMediaModels as $otherMediaModel) {
            $otherMediaArray[] = [
                'url' => $otherMediaModel->url,
                'filename' => $otherMediaModel->filename,
                'source' => [
                    'url' => $otherMediaModel->source->url,
                    'description' => $otherMediaModel->source->getDescription
                ]
            ];
        }

        $receivedByModel = $hinarioModel->receivedBy;

        $receivedByArray = [
            'slug' => $receivedByModel->getSlug(),
            'display_name' => $receivedByModel->display_name
        ];

        $hymnHinarioModels = $hinarioModel->hymnHinarios;

        $hymnHinarioArray = [];
        foreach ($hymnHinarioModels as $hymnHinarioModel) {
            $hymnModel = $hymnHinarioModel->hymn;

            $hymnRecordingArray = [];
            foreach ($recordingSourceModels as $recordingSourceModel) {
                if (!empty($hymnModel->getRecording($recordingSourceModel->id))) {
                    $hymnRecordingArray[] = [
                        'url' => $hymnModel->getRecording($recordingSourceModel->id)->url,
                    ];
                }
            }

            $hymnArray = [
                'slug' => $hymnModel->getSlug(),
                'name' => $hymnModel->getName($hymnModel->original_language_id),
                'number' => $hymnModel->getNumber($hinarioModel->id),
                'recordings' => $hymnRecordingArray
            ];

            $hymnHinarioArray[] = [
                'list_order' => $hymnHinarioModel->list_order,
                'section' => $hymnHinarioModel->getSection()->getName(),
                'hymn' => $hymnArray,
            ];
        }

        $hinarioArray = [
            'name' => $hinarioModel->getName($hinarioModel->original_language_id),
            'type_id' => $hinarioModel->type_id,
            'id' => $hinarioModel->id,
            'slug' => $hinarioModel->getSlug(),
            'hymnHinarios' => $hymnHinarioArray
        ];

        $hinarioJson = json_encode($hinarioArray);

        $hinarioModel->preloaded_json = $hinarioJson;
    }
}
