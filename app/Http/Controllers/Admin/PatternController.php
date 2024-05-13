<?php
namespace App\Http\Controllers\Admin;

use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Hymn;
use App\Models\Person;
use App\Models\Image;
use App\Models\PersonImage;
use App\Models\PersonTranslation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatternController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($id = null)
    {
        if (!empty($id)) {
            $hymn = Hymn::where('pattern_id', $id)->first();
        } else {
            $hymn = null;
        }

        $patternIds = DB::table('hymns')->select('pattern_id')->distinct()->orderBy('pattern_id')->whereNotNull('pattern_id')->get();

        $patterns = [];
        $hymns = [];
        foreach ($patternIds as $patternId) {
            if (view()->exists('hymns.patterns.' . $patternId->pattern_id)) {
                $patterns[$patternId->pattern_id] = 1;
            } else {
                $patterns[$patternId->pattern_id] = 0;
            }

            $hymnRow = Hymn::where('pattern_id', $patternId->pattern_id)->first();
            $hymns[] = $hymnRow;
        }

        return view('admin.view_pattern', [ 'hymn' => $hymn, 'patterns' => $patterns, 'hymns' => $hymns ]);
    }
}
