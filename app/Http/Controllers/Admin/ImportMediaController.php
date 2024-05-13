<?php
namespace App\Http\Controllers\Admin;

use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Hinario;
use App\Models\Person;
use App\Models\Image;
use App\Models\PersonImage;
use App\Models\PersonTranslation;
use App\Services\MediaImportService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImportMediaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $mediaImportService;

    public function __construct(MediaImportService $mediaImportService)
    {
        $this->mediaImportService = $mediaImportService;
    }

    public function showImportPeopleAudioForm()
    {
        $people = Person::where('searchable', 1)->orderBy('id')->get();

        return view('admin.import_people_audio_files', [ 'people' => $people, 'done' => [] ]);
    }

    public function showGenerateHinarioRecordingsZipsForm()
    {
        $hinarios = Hinario::orderBy('id')->get();

        return view('admin.generate_hinario_zips_form', [ 'hinarios' => $hinarios, 'done' => [] ]);
    }

    public function importPeople(Request $request)
    {
        set_time_limit(300000);

        $startDateTime = date('Y-m-d H:i:s');

        $people = $request->get('imports', []);
        if ($people == []) {
            $peopleModels = Person::where('searchable', 1)->orderBy('id')->get();
            foreach ($peopleModels as $personModel) {
                $people[] = $personModel->id;
            }
        }

        foreach ($people as $person) {
            $this->mediaImportService->importOldNossaPersonHymns($person, $startDateTime);
        }

        $done = Person::whereIn('id', $people)->orderBy('id')->get();

        $people = Person::where('searchable', 1)->orderBy('id')->get();

        return view('admin.import_people_audio_files', [ 'people' => $people, 'done' => $done ]);
    }

    public function generateHinarioRecordingsZips(Request $request)
    {
        set_time_limit(300000);

        $startDateTime = date('Y-m-d H:i:s');

        $hinarios = $request->get('hinarios', []);
        foreach ($hinarios as $hinarioId) {
            $this->mediaImportService->generateHinarioRecordingsZips($hinarioId);
        }

        $done = Hinario::whereIn('id', $hinarios)->orderBy('id')->get();

        $hinarios = Hinario::orderBy('id')->get();

        return view('admin.generate_hinario_zips_form', [ 'hinarios' => $hinarios, 'done' => $done ]);
    }
}
