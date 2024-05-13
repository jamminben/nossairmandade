<?php
namespace App\Http\Controllers;

use App\Models\Hinario;
use App\Models\Hymn;
use App\Models\UserHinario;
use App\Services\GlobalFunctions;
use App\Services\HinarioService;
use App\Services\HymnService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class HymnController extends Controller
{
    private $hymnService;
    private $hinarioService;

    private $viewDirectory;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(HymnService $hymnService, HinarioService $hinarioService)
    {
        $this->hymnService = $hymnService;
        $this->hinarioService = $hinarioService;

        $this->viewDirectory = 'hymns';
    }

    public function show($hymnId)
    {
        $hymn = Hymn::where('id', $hymnId)
            ->with('receivedBy', 'offeredTo', 'translations', 'hymnHinarios')
            ->first();

        if (Auth::check()) {
            $userHinarios = UserHinario::where('user_id', Auth::user()->getAuthIdentifier())->orderBy('name')->get();
        } else {
            $userHinarios = [];
        }

        return view('hymns.hymn', [
            "hymn" => $hymn,
            'userHinarios' => $userHinarios
        ]);
    }
}
