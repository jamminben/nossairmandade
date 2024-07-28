<?php
namespace App\Http\Controllers\Admin;

use App\Enums\HinarioTypes;
use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Hinario;
use App\Models\Hymn;
use App\Models\HymnHinario;
use App\Models\HymnMediaFile;
use App\Models\HymnNotationTranslation;
use App\Models\HymnTranslation;
use App\Models\HymnUpdateLog;
use App\Models\LanguageTranslation;
use App\Models\MediaFile;
use App\Models\MediaSource;
use App\Models\MediaSourceTranslation;
use App\Models\Person;
use App\Models\PersonTranslation;
use App\Services\GlobalFunctions;
use App\Services\HinarioService;
use App\Services\MediaImportService;
use App\Services\NotationService;
use App\Services\PatternService;
use App\Services\PersonService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HymnController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $hymnData;

    private $hinarioService;
    private $patternService;

    private $personService;

    private $mediaImportService;

    private $notationService;

    public function __construct(
        HinarioService $hinarioService,
        PatternService $patternService,
        PersonService $personService,
        MediaImportService $mediaImportService,
        NotationService $notationService)
    {
        $this->hymnData = [
            'hymnId' => 0,
            'receivedById' => 0,
            'receivedDate' => '',
            'receivedLocation' => '',
            'patternId' => 0,
            'offeredTo' => 0,
            'notationId' => 0,
            'receivedNumber' => 1,
            'hinarioId' => 0,
            'sectionNumber' => 1,
            'originalLanguageId' => 1,
            'originalName' => '',
            'originalLyrics' => '',
            'secondaryLanguageId' => 2,
            'secondaryName' => '',
            'secondaryLyrics' => '',
            'feedback' => [],
            'persons' => [],
            'patterns' => [],
            'notations' => [],
            'hinarios' => [],
            'languages' => [],
        ];

        $this->hinarioService = $hinarioService;
        $this->patternService = $patternService;
        $this->personService = $personService;
        $this->mediaImportService = $mediaImportService;
        $this->notationService = $notationService;
    }

    public function show()
    {
        $this->hymnData['persons'] = $this->loadPersons();
        $this->hymnData['patterns'] = $this->loadPatterns();
        $this->hymnData['notations'] = $this->loadNotations();
        $this->hymnData['hinarios'] = $this->loadHinarios();
        $this->hymnData['languages'] = $this->loadLanguages();

        return view('admin.edit_hymn', $this->hymnData);
    }

    public function save(Request $request)
    {
        if ($request->get('hymnId') == 0) {
            $hymn = new Hymn();
            $this->saveHymnAndPrepareVariables($request->all(), $hymn);
        } else {
            $hymn = Hymn::where('id', $request->get('hymnId'))->first();

            if ($request->get('action') == 'load') {
                $this->loadHymnAndPrepareVariables($hymn);
            } elseif ($request->get('action') == 'feedback') {
                $this->handleFeedback($request->get('feedback_id'));
                $this->loadHymnAndPrepareVariables($hymn);
            } else {
                $this->saveHymnAndPrepareVariables($request->all(), $hymn);
            }
        }

        return view('admin.edit_hymn', $this->hymnData);
    }

    public function load()
    {
        return view('admin.load_hymn');
    }

    private function loadPersons()
    {
        $persons = Person::orderBy('display_name')->get();
        return $persons;
    }

    private function loadPatterns()
    {
        $patterns = $this->patternService->getPatternsForDisplay();

        return $patterns;
    }

    private function loadNotations()
    {
        $notations = $this->notationService->getNotationsForDisplay();
        return $notations;
    }

    private function loadHinarios()
    {
        $hinariosObjects = Hinario::whereIn('type_id', [ HinarioTypes::LOCAL, HinarioTypes::INDIVIDUAL ])->get();

        $hinarios = [];
        foreach ($hinariosObjects as $hinario) {
            $hinarios[$hinario->getName()] = $hinario;
        }

        ksort($hinarios);

        $hinarios = array_values($hinarios);

        return $hinarios;
    }

    private function loadLanguages()
    {
        $languages = LanguageTranslation::where('in_language_id', GlobalFunctions::getCurrentLanguage())->orderBy('language_id')->get();
        return $languages;
    }

    private function handleFeedback($feedbackId)
    {
        $feedback = Feedback::where('id', $feedbackId)->first();
        $feedback->resolved = 1;
        $feedback->save();
    }

    private function saveHymnAndPrepareVariables($requestParams, Hymn $hymn)
    {
        if (empty($hymn->id)) {
            $blankForm = true;  // saving new hymn, blank most values, increment some, etc.
        } else {
            $blankForm = false; // saving an existing hymn, so keep all values the same in the page
        }

        $this->hymnData['persons'] = $this->loadPersons();
        $this->hymnData['patterns'] = $this->loadPatterns();
        $this->hymnData['notations'] = $this->loadNotations();
        $this->hymnData['hinarios'] = $this->loadHinarios();
        $this->hymnData['languages'] = $this->loadLanguages();
        $this->hymnData['feedback'] = $hymn->feedback;

        $this->hymnData['receivedById'] = $requestParams['received_by'];

        // received_by
        if ($requestParams['received_by'] == 0 && $requestParams['new_received_by'] != '') {
            // make new person
            $person = new Person();
            $person->full_name = $requestParams['new_received_by'];
            $person->display_name = $requestParams['new_received_by'];
            $person->searchable = 0;
            $person->save();
            $this->hymnData['receivedById'] = $person->id;

            // make translations
            foreach ($this->hymnData['languages'] as $language) {
                $personTranslation = new PersonTranslation();
                $personTranslation->person_id = $person->id;
                $personTranslation->language_id = $language->id;
                $personTranslation->description = '';
                $personTranslation->save();
            }
        }

        // offered_to
        if ($requestParams['offered_to'] != 0) {
            $hymn->offered_to = $requestParams['offered_to'];
            if (!$blankForm) {
                $this->hymnData['offeredTo'] = $requestParams['offered_to'];
            }
        } elseif ($requestParams['offered_to'] == 0 && $requestParams['new_offered_to'] != '') {
            // make new person
            $person = new Person();
            $person->full_name = $requestParams['new_offered_to'];
            $person->display_name = $requestParams['new_offered_to'];
            $person->searchable = 0;
            $person->save();
            $hymn->offered_to = $person->id;
            if (!$blankForm) {
                $this->hymnData['offeredTo'] = $person->id;
            }

            // make translations
            foreach ($this->hymnData['languages'] as $language) {
                $personTranslation = new PersonTranslation();
                $personTranslation->person_id = $person->id;
                $personTranslation->language_id = $language->id;
                $personTranslation->description = '';
                $personTranslation->save();
            }
        }

        // hymn
        $hymn->received_by = $this->hymnData['receivedById'];
        if ($requestParams['received_date'] != '' && $requestParams['received_date'] != '0000-00-00') {
            $hymn->received_date = date('Y-m-d H:i:s', strtotime($requestParams['received_date']));
            if (!$blankForm) {
                $this->hymnData['receivedDate'] = date('Y-m-d H:i:s', strtotime($requestParams['received_date']));
            }
        } else {
            $hymn->received_date = null;
        }
        if ($requestParams['received_location'] != '') {
            $hymn->received_location = $requestParams['received_location'];
            if (!$blankForm) {
                $this->hymnData['receivedLocation'] = $requestParams['received_location'];
            }
        }
        if ($requestParams['pattern_id'] != '') {
            $hymn->pattern_id = $requestParams['pattern_id'];
            if (!$blankForm) {
                $this->hymnData['patternId'] = $requestParams['pattern_id'];
            }
        }

        if ($requestParams['notation_id'] != '') {
            $hymn->notation = $requestParams['notation_id'];
            if (!$blankForm) {
                $this->hymnData['notationId'] = $requestParams['notation_id'];
            }
        }
        $hymn->original_language_id = $requestParams['original_language_id'];
        $this->hymnData['originalLanguageId'] = $requestParams['original_language_id'];
        if ($requestParams['received_number'] != '' && $requestParams['received_number'] > 0) {
            $hymn->received_order = $requestParams['received_number'];
            if (!$blankForm) {
                $this->hymnData['receivedNumber'] = $requestParams['received_number'];
            } else {
                $this->hymnData['receivedNumber'] = $requestParams['received_number'] + 1;
            }
        } else {
            $this->hymnData['receivedNumber'] = 1;
        }

        if ($requestParams['hinario'] != '') {
            $hymn->received_hinario_id = $requestParams['hinario'];
            $this->hymnData['hinarioId'] = $requestParams['hinario'];
        } else {
            $this->hymnData['hinarioId'] = 0;
        }
        $hymn->save();
        if (!$blankForm) {
            $this->hymnData['hymnId'] = $hymn->id;
        }

        // hymn_translation
        if ($requestParams['original_lyrics'] != '' || $requestParams['original_name'] != '') {
            $hymnTranslation = $hymn->getPrimaryTranslation();
            if (empty($hymnTranslation)) {
                $hymnTranslation = new HymnTranslation();
            }
            $hymnTranslation->hymn_id = $hymn->id;
            $hymnTranslation->language_id = $requestParams['original_language_id'];
            $hymnTranslation->name = $requestParams['original_name'];
            $hymnTranslation->lyrics = $requestParams['original_lyrics'];
            $hymnTranslation->save();

            if (!$blankForm) {
                $this->hymnData['originalName'] = $requestParams['original_name'];
                $this->hymnData['originalLyrics'] = $requestParams['original_lyrics'];
            }
        }

        if ($requestParams['secondary_lyrics'] != '' || $requestParams['secondary_name'] != '') {
            $hymnTranslation = $hymn->getTranslation($requestParams['secondary_language_id']);
            if (empty($hymnTranslation)) {
                $hymnTranslation = new HymnTranslation();
            }

            $hymnTranslation->hymn_id = $hymn->id;
            $hymnTranslation->language_id = $requestParams['secondary_language_id'];
            $hymnTranslation->name = $requestParams['secondary_name'];
            $hymnTranslation->lyrics = $requestParams['secondary_lyrics'];
            $hymnTranslation->save();

            if (!$blankForm) {
                $this->hymnData['secondaryName'] = $requestParams['secondary_name'];
                $this->hymnData['secondaryLyrics'] = $requestParams['secondary_lyrics'];
            }
        }

        // hymn_hinario
        if ($requestParams['hinario'] != '' && $blankForm) {
            if (!empty($requestParams['section']) && is_numeric($requestParams['section'])) {
                $section = $requestParams['section'];
            } else {
                $section = 1;
            }
            $this->hymnData['sectionNumber'] = $section;
            $highestHymnHinario = HymnHinario::where('hinario_id', $requestParams['hinario'])
                ->where('section_number', $section)
                ->orderBy('list_order', 'DESC')
                ->first();

            $hymnHinario = new HymnHinario();
            $hymnHinario->hymn_id = $hymn->id;
            $hymnHinario->hinario_id = $requestParams['hinario'];
            $hymnHinario->section_number = $section;
            if (!empty($highestHymnHinario)) {
                $hymnHinario->list_order = $highestHymnHinario->list_order + 1;
            } else {
                $hymnHinario->list_order = 1;
            }
            $hymnHinario->original_hinario = 1;
            $hymnHinario->save();
        }

        if ($blankForm) {
            $this->hymnData['hymnId'] = 0;
        } else {
            $this->hymnData['hymnId'] = $hymn->id;
        }
    }

    private function loadHymnAndPrepareVariables(Hymn $hymn)
    {
        $this->hymnData['persons'] = $this->loadPersons();
        $this->hymnData['patterns'] = $this->loadPatterns();
        $this->hymnData['notations'] = $this->loadNotations();
        $this->hymnData['hinarios'] = $this->loadHinarios();
        $this->hymnData['languages'] = $this->loadLanguages();

        // hymn
        $this->hymnData['hymnId'] = $hymn->id;
        $this->hymnData['receivedById'] = $hymn->received_by;
        $this->hymnData['offeredTo'] = $hymn->offered_to;
        if ($hymn->received_date != '0000-00-00') {
            $this->hymnData['receivedDate'] = $hymn->received_date;
        } else {
            $this->hymnData['receivedDate'] = null;
        }
        $this->hymnData['receivedLocation'] = $hymn->received_location;
        $this->hymnData['patternId'] = $hymn->pattern_id;
        $this->hymnData['notationId'] = $hymn->notation;
        $this->hymnData['originalLanguageId'] = $hymn->original_language_id;
        $this->hymnData['receivedNumber'] = $hymn->received_order;
        $this->hymnData['hinarioId'] = $hymn->received_hinario_id;

        // hymn_translation
        $hymnTranslation = $hymn->getPrimaryTranslation();
        if (!empty($hymnTranslation)) {
            $this->hymnData['originalName'] = $hymnTranslation->name;
            $this->hymnData['originalLyrics'] = $hymnTranslation->lyrics;
        } else {
            $this->hymnData['originalName'] = '';
            $this->hymnData['originalLyrics'] = '';
        }

        $hymnTranslations = $hymn->getSecondaryTranslations();
        if (count($hymnTranslations) > 0) {
            $hymnTranslation = $hymn->getSecondaryTranslations()[0];
            $this->hymnData['secondaryLanguageId'] = $hymnTranslation->language_id;
            $this->hymnData['secondaryName'] = $hymnTranslation->name;
            $this->hymnData['secondaryLyrics'] = $hymnTranslation->lyrics;
        }

        // hymn_hinario
        $hymnHinario = HymnHinario::where('hymn_id', $hymn->id)
            ->where('hinario_id', $hymn->original_hinario_id)
            ->where('original_hinario', '1')
            ->first();
        if (!empty($hymnHinario)) {
            $this->hymnData['sectionNumber'] = $hymnHinario->section_number;
            $this->hymnData['receivedNumber'] = $hymnHinario->list_order;
        }

        // feedback
        $this->hymnData['feedback'] = $hymn->feedback;
    }

    public function loadHymn($hymnId)
    {
        $hymn = Hymn::where('id', $hymnId)->first();

        if (is_null(Auth::user()) || !Auth::user()->canEditHymn($hymnId))
        {
            return redirect()->to(url('hymn/' . $hymnId . '/' . $hymn->getPrimaryTranslation()->name));
        }

        $patterns = $this->loadPatterns();
        $patternIds = [];
        foreach ($patterns as $pattern) {
            $patternIds[] = $pattern->id;
        }

        $notations = $this->loadNotations();

        return view('admin.hymns.hymn',
            [
                'hymn' => $hymn,
                'persons' => $this->loadPersons(),
                'notations' => $this->loadNotations(),
                'patternIds' => $patternIds,
                'languages' => $this->loadLanguages(),
            ]);
    }

    public function saveHymn(Request $request)
    {
        $hymnId = $request->get('hymnId');

        $hymn = Hymn::where('id', $hymnId)->first();

        if (is_null(Auth::user()) || !Auth::user()->canEditHymn($hymnId))
        {
            return redirect()->to(url('hymn/' . $hymnId . '/' . $hymn->getPrimaryTranslation()->name));
        }

        $this->saveHymnEdit($request->all(), $hymn);
        $hymn->refresh();

        foreach ($hymn->hinarios as $hinario)
        {
            $this->hinarioService->preloadHinario($hinario->id);
        }

        return redirect()->to(url('hymn/' . $hymn->id . '/' . $hymn->getPrimaryTranslation()->name));
    }

    private function saveHymnEdit($requestParams, Hymn $hymn)
    {
        $oldVersion = [];
        $newVersion = [];

        // received_by
        if (is_null($hymn->receivedBy) ||
            ($requestParams['received_by'] != '' && $requestParams['received_by'] != $hymn->receivedBy->display_name)) {
            $oldVersion['hymn']['receivedBy'] = $hymn->receivedBy->display_name;
            $newVersion['hymn']['receivedBy'] = $requestParams['received_by'];
            $hymn->received_by = $this->personService->getIdFromDisplayName($requestParams['received_by'], true);
        }

        // offered_to
        if (is_null($hymn->offeredTo) ||
            ($requestParams['offered_to'] != '' && $requestParams['offered_to'] != $hymn->offeredTo->display_name)) {
            $oldVersion['hymn']['offeredTo'] = $hymn->offered_to;
            $newVersion['hymn']['offeredTo'] = $requestParams['offered_to'];
            $hymn->offered_to = $this->personService->getIdFromDisplayName($requestParams['offered_to'], true);
        }

        // hymn
        if ($requestParams['received_date'] != $hymn->received_date) {
            $oldVersion['hymn']['received_date'] = $hymn->received_date;
            $newVersion['hymn']['received_date'] = date('Y-m-d H:i:s', strtotime($requestParams['received_date']));
            $hymn->received_date = date('Y-m-d H:i:s', strtotime($requestParams['received_date']));
        }
        if ($requestParams['received_location'] != $hymn->received_location) {
            $oldVersion['hymn']['received_location'] = $hymn->received_location;
            $newVersion['hymn']['received_location'] = $requestParams['received_location'];
            $hymn->received_location = $requestParams['received_location'];
        }
        if ($requestParams['pattern_id'] != $hymn->pattern_id) {
            $oldVersion['hymn']['pattern_id'] = $hymn->pattern_id;
            $newVersion['hymn']['pattern_id'] = $requestParams['pattern_id'];
            $hymn->pattern_id = $requestParams['pattern_id'];
        }
        if ($requestParams['notation_id'] != $hymn->notation) {
            $oldVersion['hymn']['notation'] = $hymn->notation;
            $newVersion['hymn']['notation'] = $requestParams['notation_id'];
            $hymn->notation = $requestParams['notation_id'];
        }
        if ($requestParams['original_language_id'] != $hymn->original_language_id) {
            $oldVersion['hymn']['original_language_id'] = $hymn->original_language_id;
            $newVersion['hymn']['original_language_id'] = $requestParams['original_language_id'];
            $hymn->original_language_id = $requestParams['original_language_id'];
        }

        $hymn->save();

        // hymn_translation
        if ($requestParams['original_lyrics'] != '' || $requestParams['original_name'] != '') {
            $hymnTranslation = $hymn->getPrimaryTranslation();
            if (empty($hymnTranslation)) {
                $hymnTranslation = new HymnTranslation();
            }

            if ($requestParams['original_lyrics'] != $hymnTranslation->lyrics || $requestParams['original_name'] != $hymnTranslation->name) {
                $hymnTranslation->hymn_id = $hymn->id;
                if ($requestParams['original_language_id'] != $hymnTranslation->language_id) {
                    $oldVersion['primary_translation']['language_id'] = $hymnTranslation->language_id;
                    $newVersion['primary_translation']['language_id'] = $requestParams['original_language_id'];
                    $hymnTranslation->language_id = $requestParams['original_language_id'];
                }
                if ($requestParams['original_name'] != $hymnTranslation->name) {
                    $oldVersion['primary_translation']['name'] = $hymnTranslation->name;
                    $newVersion['primary_translation']['name'] = $requestParams['original_name'];
                    $hymnTranslation->name = $requestParams['original_name'];
                }
                if ($requestParams['original_lyrics'] != $hymnTranslation->lyrics) {
                    $oldVersion['primary_translation']['lyrics'] = $hymnTranslation->lyrics;
                    $newVersion['primary_translation']['lyrics'] = $requestParams['original_lyrics'];
                    $hymnTranslation->lyrics = $requestParams['original_lyrics'];
                }
                $hymnTranslation->save();
            }
        }

        if ($requestParams['secondary_lyrics'] != '' || $requestParams['secondary_name'] != '') {
            $hymnTranslation = $hymn->getTranslation($requestParams['secondary_language_id']);
            if (empty($hymnTranslation)) {
                $hymnTranslation = new HymnTranslation();
            }

            if ($requestParams['secondary_lyrics'] != $hymnTranslation->lyrics || $requestParams['secondary_name'] != $hymnTranslation->name) {
                $hymnTranslation->hymn_id = $hymn->id;
                if ($requestParams['secondary_language_id'] != $hymnTranslation->language_id) {
                    $oldVersion['secondary_translation']['language_id'] = $hymnTranslation->language_id;
                    $newVersion['secondary_translation']['language_id'] = $requestParams['secondary_language_id'];
                    $hymnTranslation->language_id = $requestParams['secondary_language_id'];
                }
                if ($requestParams['secondary_name'] != $hymnTranslation->name) {
                    $oldVersion['secondary_translation']['name'] = $hymnTranslation->name;
                    $newVersion['secondary_translation']['name'] = $requestParams['secondary_name'];
                    $hymnTranslation->name = $requestParams['secondary_name'];
                }
                if ($requestParams['secondary_lyrics'] != $hymnTranslation->lyrics) {
                    $oldVersion['secondary_translation']['lyrics'] = $hymnTranslation->lyrics;
                    $newVersion['secondary_translation']['lyrics'] = $requestParams['secondary_lyrics'];
                    $hymnTranslation->lyrics = $requestParams['secondary_lyrics'];
                }
                $hymnTranslation->save();
            }
        }

        // delete media files and mark as official
        foreach ($hymn->mediaFiles as $file)
        {
            $hymnMediaFile = HymnMediaFile::where('hymn_id', $hymn->id)->where('media_file_id', $file->id)->first();
            if (isset($requestParams['actions_'.$file->id])) {
                switch ($requestParams['actions_'.$file->id]) {
                    case 'delete':
                        $oldVersion['hymn_media']['media_file_id'][] = 'delete hymn_media_file ' . $file->id;
                        $hymnMediaFile->delete();
                        break;
                    case 'mark_official':
                        if ($hymnMediaFile->official != 1) {
                            $oldVersion['hymn_media']['media_file_id'][] = 'mark official hymn_media_file ' . $hymnMediaFile->id;
                            $hymnMediaFile->official = 1;
                            $hymnMediaFile->save();
                        }
                        break;
                    case 'unmark_official':
                        if ($hymnMediaFile->official != 0) {
                            $oldVersion['hymn_media']['media_file_id'][] = 'unmark official hymn_media_file ' . $hymnMediaFile->id;
                            $hymnMediaFile->official = 0;
                            $hymnMediaFile->save();
                        }
                        break;
                }
            }

            if (isset($requestParams['delete_media_file_' . $file->id])) {
                $hymnMediaFile->delete();
                $oldVersion['hymn_media']['media_file_id'][] = 'delete hymn_media_file ' . $file->id;
            }
        }

        // new media files
        $oldName = $_FILES['new_media']['name'];
        if (!empty($oldName)) {
            $sourceId = $this->mediaImportService->makeNewSource($requestParams['new_source_description'], $requestParams['new_source_url']);
            $hymnMediaFileId = $this->mediaImportService->addMediaToHymn($hymn->id, $sourceId);
            $newVersion['hymn_media']['media_file_id'][] = $hymnMediaFileId;
        }

        $hymnUpdateLog = new HymnUpdateLog();
        $hymnUpdateLog->hymn_id = $hymn->id;
        $hymnUpdateLog->updated_by = Auth::user()->id;
        $hymnUpdateLog->updated_at = date('Y-m-d H:i:s');
        $hymnUpdateLog->old_version = json_encode($oldVersion);
        $hymnUpdateLog->new_version = json_encode($newVersion);
        $hymnUpdateLog->save();
    }
}
