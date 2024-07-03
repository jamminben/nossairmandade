<?php
namespace App\Http\Controllers\Admin;

use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Hymn;
use App\Models\HymnPattern;
use App\Models\Person;
use App\Models\Image;
use App\Models\PersonImage;
use App\Models\PersonTranslation;
use App\Services\GlobalFunctions;
use App\Services\PatternService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatternController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $patternService;

    public function __construct(PatternService $patternService)
    {
        $this->patternService = $patternService;
    }

    public function samplePattern($patternId = null)
    {
        if (is_null($patternId)) {
            $patternId = 0;
        }

        $pattern = HymnPattern::where('pattern_id', $patternId)->first();

        return view('admin.hymns.sample_pattern', [ 'pattern' => $pattern, 'language' => GlobalFunctions::getCurrentLanguage() ]);
    }

    public function allPatterns()
    {
        $patterns = $this->patternService->getPatternsForDisplay();

        return view('admin.hymns.all_patterns', [ 'patterns' => $patterns ]);
    }
}
