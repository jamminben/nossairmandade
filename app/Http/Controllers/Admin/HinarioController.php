<?php
namespace App\Http\Controllers\Admin;

use App\Enums\HinarioTypes;
use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Hinario;
use App\Models\HinarioMediaFile;
use App\Models\HinarioSection;
use App\Models\HinarioSectionTranslation;
use App\Models\HinarioTranslation;
use App\Models\HinarioUpdateLog;
use App\Models\Hymn;
use App\Models\HymnHinario;
use App\Models\HymnNotationTranslation;
use App\Models\HymnTranslation;
use App\Models\LanguageTranslation;
use App\Models\Person;
use App\Models\PersonTranslation;
use App\Services\GlobalFunctions;
use App\Services\HinarioService;
use App\Services\MediaImportService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Tag\Section;
use App\Services\HymnService;

class HinarioController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $hinarioService;
    private $hymnService;

    private $mediaImportService;

    public function __construct(HinarioService $hinarioService, HymnService $hymnService, MediaImportService $mediaImportService)
    {
        $this->hinarioService = $hinarioService;
        $this->hymnService = $hymnService;
        $this->mediaImportService = $mediaImportService;
    }

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

    public function loadHinario($hinarioId, $hinarioName = null)
    {
        $hinario = Hinario::where('id', $hinarioId)
            ->with('translations', 'sections', 'hymns', 'hymnHinarios', 'hymnHinarios.hinario', 'receivedBy', 'hymns.mediaFiles', 'hymns.translations', 'hymns.hymnHinarios')
            ->first();

        if (is_null(Auth::user()) || !Auth::user()->canEditHinario($hinarioId)) {
            return redirect()->to(url('hinario/' . $hinarioId . '/' . $hinario->getPrimaryTranslation()->name));
        }

        $displaySections = count($hinario->getSections()) > 1;

        $persons = Person::all();

        return view('admin.hinarios.hinario',
            [
                'hinario' => $hinario,
                'sections' => $hinario->getSections(),
                'displaySections' => $displaySections,
                'persons' => $persons,
                'languages' => $this->loadLanguages()
            ]);
    }

    private function loadLanguages()
    {
        // TODO: make the 2 in the line below be whatever the user's active language id is
        $languages = LanguageTranslation::where('in_language_id', 2)->orderBy('language_id')->get();
        return $languages;
    }

    public function saveHinario(Request $request)
    {
        $hinarioId = $request->get('hinarioId');

        $hinario = Hinario::where('id', $hinarioId)->first();

        if (is_null(Auth::user()) || !Auth::user()->canEditHinario($hinarioId)) {
            return redirect()->to(url('hinario/' . $hinarioId . '/' . $hinario->getPrimaryTranslation()->name));
        }

        $this->saveHinarioEdit($request->all(), $hinario);

        $this->hinarioService->preloadHinario($hinarioId);

        return redirect()->to(url('hinario/' . $hinarioId . '/' . $hinario->getName(GlobalFunctions::getCurrentLanguage())));
    }

    private function saveHinarioEdit($requestParams, Hinario $hinario)
    {
        $oldVersion = [];
        $newVersion = [];

        // hinario_translation
        if ($requestParams['name'] != '') {
            $hinarioTranslation = $hinario->getPrimaryTranslation();
            if (empty($hinarioTranslation)) {
                $hinarioTranslation = new HinarioTranslation();
            }

            if ($requestParams['name'] != $hinarioTranslation->name) {
                $hinarioTranslation->hinario_id = $hinario->id;
                if ($requestParams['original_language_id'] != $hinarioTranslation->language_id) {
                    $oldVersion['primary_translation']['language_id'] = $hinarioTranslation->language_id;
                    $newVersion['primary_translation']['language_id'] = $requestParams['original_language_id'];
                    $hinarioTranslation->language_id = $requestParams['original_language_id'];
                }
                if ($requestParams['name'] != $hinarioTranslation->name) {
                    $oldVersion['primary_translation']['name'] = $hinarioTranslation->name;
                    $newVersion['primary_translation']['name'] = $requestParams['name'];
                    $hinarioTranslation->name = $requestParams['name'];
                }
                $hinarioTranslation->save();
            }
        }

        if ($requestParams['secondary_name'] != '') {
            $hinarioTranslation = $hinario->getTranslation($requestParams['secondary_language_id']);
            if (empty($hinarioTranslation)) {
                $hinarioTranslation = new HinarioTranslation();
            }

            if ($requestParams['secondary_name'] != $hinarioTranslation->name) {
                $hinarioTranslation->hinario_id = $hinario->id;
                if ($requestParams['secondary_language_id'] != $hinarioTranslation->language_id) {
                    $oldVersion['secondary_translation']['language_id'] = $hinarioTranslation->language_id;
                    $newVersion['secondary_translation']['language_id'] = $requestParams['secondary_language_id'];
                    $hinarioTranslation->language_id = $requestParams['secondary_language_id'];
                }
                if ($requestParams['name'] != $hinarioTranslation->name) {
                    $oldVersion['secondary_translation']['name'] = $hinarioTranslation->name;
                    $newVersion['secondary_translation']['name'] = $requestParams['secondary_name'];
                    $hinarioTranslation->name = $requestParams['secondary_name'];
                }
                $hinarioTranslation->save();
            }
        }

        // update section names
        foreach ($hinario->getSections() as $section) {
            if (isset($requestParams['section_' . $section->id]) && $requestParams['section_' . $section->id] != $section->getName()) {
                $sectionTranslation = $section->getTranslation($hinario->original_language_id);
                if (empty($sectionTranslation)) {
                    $sectionTranslation = new HinarioSectionTranslation();
                    $sectionTranslation->name = '';
                    $sectionTranslation->hinario_section_id = $section->id;
                    $sectionTranslation->language_id = $hinario->original_language_id;
                }

                $oldVersion['sections'][$section->id]['name'] = $sectionTranslation->name;

                $sectionTranslation->name = $requestParams['section_' . $section->id];

                $newVersion['sections'][$section->id]['name'] = $requestParams['section_' . $section->id];

                $sectionTranslation->save();
            }

            if (isset($requestParams['section_secondary_' . $section->id]) && $requestParams['section_secondary_' . $section->id] != $section->getName($requestParams['secondary_language_id'])) {
                $secondarySectionTranslation = $section->getTranslation($requestParams['secondary_language_id']);
                if (empty($secondarySectionTranslation)) {
                    $secondarySectionTranslation = new HinarioSectionTranslation();
                    $secondarySectionTranslation->name = '';
                    $secondarySectionTranslation->hinario_section_id = $section->id;
                    $secondarySectionTranslation->language_id = $hinario->original_language_id;
                }

                $oldVersion['sections'][$section->id]['name'] = $secondarySectionTranslation->name;

                $secondarySectionTranslation->name = $requestParams['section_secondary_' . $section->id];

                $newVersion['sections'][$section->id]['name'] = $requestParams['section_secondary_' . $section->id];

                $secondarySectionTranslation->save();
            }
        }

        // add section
        if (isset($requestParams['add_section']) && !empty($requestParams['add_section_name'])) {
            $this->hinarioService->addSection($hinario, $requestParams['add_section_name'], $requestParams['secondary_language_id'], $requestParams['secondary_name']);
        }

        foreach ($hinario->hymnHinarios as $hymnHinario) {
            // delete hymns
            if (isset($requestParams['delete_hymn_' . $hymnHinario->id])) {
                foreach($hinario->hymnHinarios->where('section_number', $hymnHinario->section_number)->where('list_order', '>', $hymnHinario->list_order) as $higherHymnHinario) {
                    $higherHymnHinario->list_order -= 1;
                    $higherHymnHinario->save();
                }
                $hymnHinario->delete();
                $oldVersion['hymns']['delete'][] = [
                    'hymn' => $hymnHinario->hymn_id,
                    'hymnHinario' => $hymnHinario->id
                ];
            }

            // add hymns
            if (isset($requestParams['add_hymn_' . $hymnHinario->id])) {
                foreach($hinario->hymnHinarios->where('section_number', $hymnHinario->section_number)->where('list_order', '>', $hymnHinario->list_order) as $higherHymnHinario) {
                    $higherHymnHinario->list_order += 1;
                    $higherHymnHinario->save();
                }

                $newHymnHinario = $this->hymnService->makeNewHymn($hinario, $hymnHinario);

                $oldVersion['hymns']['add'][] = [
                    'hymn' => $newHymnHinario->hymn_id,
                    'hymnHinario' => $newHymnHinario->id
                ];
            }
        }

        // delete media files
        foreach ($hinario->mediaFiles as $file) {
            if (isset($requestParams['delete_media_file_'.$file->id]) && $requestParams['delete_media_file_'.$file->id]) {
                $oldVersion['hymn_media']['media_file_id'] = 'delete hinario_media_file ' . $file->id;
                $hinarioMediaFile = HinarioMediaFile::where('hinario_id', $hinario->id)->where('media_file_id', $file->id)->first();
                $hinarioMediaFile->delete();
            }
        }

        // new media files
        if (isset($_FILES['new_media'])) {
            $oldName = $_FILES['new_media']['name'];
            if (!empty($oldName)) {
                $sourceId = $this->mediaImportService->makeNewSource($requestParams['new_source_description'], $requestParams['new_source_url']);
                $hymnMediaFileId = $this->mediaImportService->addMediaToHinario($hinario->id, $sourceId);
                $newVersion['hymn_media']['media_file_id'][] = $hymnMediaFileId;
            }
        }

        $hinarioUpdateLog = new HinarioUpdateLog();
        $hinarioUpdateLog->hinario_id = $hinario->id;
        $hinarioUpdateLog->updated_by = Auth::user()->id;
        $hinarioUpdateLog->updated_at = date('Y-m-d H:i:s');
        $hinarioUpdateLog->old_version = json_encode($oldVersion);
        $hinarioUpdateLog->new_version = json_encode($newVersion);
        $hinarioUpdateLog->save();
    }
}
