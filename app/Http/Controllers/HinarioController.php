<?php
namespace App\Http\Controllers;

use App\Enums\Languages;
use App\Models\Hinario;
use App\Models\UserHinario;
use App\Services\GlobalFunctions;
use App\Services\HinarioService;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;


class HinarioController extends Controller
{
    private $hinarioService;

    public function __construct(HinarioService $hinarioService) {
        $this->hinarioService = $hinarioService;
    }

    public function show($hinarioId, $hinarioName = null)
    {
        $hinario = Hinario::where('id', $hinarioId)
            ->with('translations', 'sections', 'hymns', 'hymnHinarios', 'hymnHinarios.hinario', 'receivedBy', 'hymns.mediaFiles', 'hymns.translations', 'hymns.hymnHinarios')
            ->first();

        GlobalFunctions::setActiveHinario($hinarioId);

        // this is for the add hymn forms
        if (Auth::check()) {
            $userHinarios = UserHinario::where('user_id', Auth::user()->getAuthIdentifier())->orderBy('name')->get();
        } else {
            $userHinarios = [];
        }

        $displaySections = count($hinario->getSections()) > 1;

        return view('hinarios.hinario', [ 'hinario' => $hinario, 'sections' => $hinario->getSections(), 'userHinarios' => $userHinarios, 'displaySections' => $displaySections ]);
    }

    public function showPreloaded($hinarioId, $hinarioName = null)
    {
        $hinario = Hinario::where('id', $hinarioId)->first();
        GlobalFunctions::setActiveHinario($hinarioId);
        
        // this is for the add hymn forms
        if (Auth::check()) {
            $userHinarios = UserHinario::where('user_id', Auth::user()->getAuthIdentifier())->orderBy('name')->get();
        } else {
            $userHinarios = [];
        }

        $displaySections = count($hinario->getSections()) > 1;

        if (empty($hinario->preloaded_json)) {
            $this->hinarioService->preloadHinario($hinarioId);
            $hinario->refresh();
        }

        $hinarioData = json_decode($hinario->preloaded_json);

        return view('hinarios.hinario',
            [
                'hinarioModel' => $hinario,
                'hinario' => $hinarioData,
                'userHinarios' => $userHinarios
            ]
        );
    }

    public function userHinario($code)
    {
        $hinario = UserHinario::where('code', $code)->first();
        // this is for the add hymn forms
        if (Auth::check()) {
            $userHinarios = UserHinario::where('user_id', Auth::user()->getAuthIdentifier())->where('id','!=',$hinario->id)->orderBy('name')->get();
        } else {
            $userHinarios = [];
        }

        return view('hinarios.user_hinario', [ 'hinario' => $hinario, 'userHinarios' => $userHinarios ]);
    }

    public function plainText($hinarioId, $hinarioName)
    {
        $hinario = Hinario::where('id', $hinarioId)->first();

        return view('hinarios.plain-text', [ 'hinario' => $hinario, 'sections' => $hinario['sections'] ]);
    }

    public function showPdf($hinarioId, $hinarioName)
    {
        $html = '';
        $hinario = Hinario::where('id', $hinarioId)
            ->with(
                'translations',
                'sections',
                'hymns',
                'hymnHinarios',
                'hymnHinarios.hinario',
                'receivedBy',
                'hymns.mediaFiles',
                'hymns.translations',
                'hymns.hymnHinarios',
                'hymns.notationTranslations'
            )
            ->first();

        $sections = $hinario->getSections();

        $hinarioHasTranslations = $hinario->hasTranslationsForLanguage(GlobalFunctions::getCurrentLanguage());

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [139, 216]]);

        $mpdf->WriteHTML(view('hinarios.print.title_page', [ 'hinario' => $hinario ])->render());
        $html .= view('hinarios.print.title_page', [ 'hinario' => $hinario ])->render();
        $totalPageCount = 2;

        $mpdf->setFooter('{PAGENO}');

        foreach ($sections as $section) {
            if (count($sections) > 1) {
                $mpdf->WriteHTML(view('hinarios.print.section_page', ['section' => $section])->render());
                $html .= view('hinarios.print.section_page', ['section' => $section])->render();
                $totalPageCount++;
            }

            foreach ($hinario->getHymnsForSection($section->section_number) as $hymn) {

                $stanzas = $hymn->stanzas($hymn->original_lanaguage_id);
                if ($hymn->original_language_id != GlobalFunctions::getCurrentLanguage()) {
                    $stanzas2 = $hymn->stanzas(GlobalFunctions::getCurrentLanguage());
                    if (!empty($stanzas2)) {
                        $hasTranslation = true;
                    } else {
                        $hasTranslation = false;
                    }
                } else {
                    $stanzas2 = [];
                    $hasTranslation = false;
                }

                if (($totalPageCount % 2) != 0 && count($stanzas2) > 0) {
                    $mpdf->WriteHTML(view('hinarios.print.blank_page')->render());
                    $totalPageCount++;
                }

                $pageNumber = 1;
                $loops = 0;

                // while we still have stanzas
                while (count($stanzas) > 0) {
                    $loops++;
                    $lineCount = 0;
                    $preparedStanzas = [];
                    $preparedStanzas2 = [];

                    // Walk through remaining stanzas checking to see it there's room to add them
                    for ($x = 0; $x < count($stanzas); $x++) {

                        // if there is room for the new stanza, add it
                        if ($lineCount + count($stanzas[$x]->getLines()) <= 29) {
                            $preparedStanzas[] = $stanzas[$x];
                            $lineCount += count($stanzas[$x]->getLines());
                            if ($x < (count($stanzas)-1)) {
                                $lineCount++;
                            }

                            if ($hasTranslation) {
                                if (!isset($stanzas2[$x])) {
                                    echo $x; die(print_r($stanzas2));
                                }
                                $preparedStanzas2[] = $stanzas2[$x];
                            }

                            // mamae o mamae
                            if (count($preparedStanzas) == 4 && $hymn->pattern_id == 46
                            ) {
                                $lineCount = 30;
                                $x = 1000;
                            }

                            // Joao Pereira #43
                            if ($hymn->pattern_id == 52 && count($preparedStanzas) == 5) {
                                $lineCount = 30;
                                $x = 1000;
                            }

                            // hymn patterns that require starting each page on an even number
                            if (in_array($hymn->pattern_id, [48, 52]) && (count($preparedStanzas) % 4 == 0)) {
                                $lineCount = 30;
                                $x = 1000;
                            }

                        } else {
                            $x = 1000;
                            $lineCount = 1000;
                        }

                    }

                    // remove the prepared stanzas from the list
                    array_splice($stanzas, 0, count($preparedStanzas));
                    if ($hasTranslation) {
                        array_splice($stanzas2, 0, count($preparedStanzas2));
                    }

                    // translated page
                    if (count($preparedStanzas2) > 0) {

                        if ($pageNumber == 1) {
                            $mpdf->WriteHTML(view('hinarios.print.hymn_header', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => GlobalFunctions::getCurrentLanguage(), 'pageCount' => $totalPageCount])->render());
                            $html .= view('hinarios.print.hymn_header', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => GlobalFunctions::getCurrentLanguage(), 'pageCount' => $totalPageCount])->render();
                        } else {
                            $mpdf->WriteHTML(view('hinarios.print.hymn_header_continued', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => GlobalFunctions::getCurrentLanguage(), 'pageCount' => $totalPageCount])->render());
                            $html .= view('hinarios.print.hymn_header_continued', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => GlobalFunctions::getCurrentLanguage(), 'pageCount' => $totalPageCount])->render();
                        }

                        if (view()->exists('hymns.patterns.print.' . $hymn->pattern_id)) {
                            $mpdf->WriteHTML(view('hymns.patterns.print.' . $hymn->pattern_id, [ 'stanzas' => $preparedStanzas2, 'pageNumber' => $pageNumber ])->render());
                            $html .= view('hymns.patterns.print.' . $hymn->pattern_id, [ 'stanzas' => $preparedStanzas2, 'pageNumber' => $pageNumber ])->render();
                        } else {
                            $mpdf->WriteHTML(view('hymns.patterns.print.0', [ 'stanzas' => $preparedStanzas2, 'pageNumber' => $pageNumber ])->render());
                            $html .= view('hymns.patterns.print.0', [ 'stanzas' => $preparedStanzas2, 'pageNumber' => $pageNumber ])->render();
                        }

                        if (count($stanzas2) == 0) {
                            $mpdf->WriteHTML(view('hinarios.print.hymn_footer', ['hymn' => $hymn])->render());
                            $html .= view('hinarios.print.hymn_footer', ['hymn' => $hymn])->render();
                        } else {
                            $mpdf->WriteHTML(view('hinarios.print.hymn_continued', ['hymn' => $hymn])->render());
                            $html .= view('hinarios.print.hymn_continued', ['hymn' => $hymn])->render();
                        }

                        $totalPageCount++;
                    }

                    // page header - original language
                    if ($pageNumber == 1) {
                        $mpdf->WriteHTML(view('hinarios.print.hymn_header', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => $hinario->original_language_id, 'pageCount' => $totalPageCount ])->render());
                        $html .= view('hinarios.print.hymn_header', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => $hinario->original_language_id, 'pageCount' => $totalPageCount])->render();
                    } else {
                        $mpdf->WriteHTML(view('hinarios.print.hymn_header_continued', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => $hinario->original_language_id, 'pageCount' => $totalPageCount])->render());
                        $html .= view('hinarios.print.hymn_header_continued', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => $hinario->original_language_id, 'pageCount' => $totalPageCount])->render();
                    }

                    // first page
                    if (view()->exists('hymns.patterns.print.' . $hymn->pattern_id)) {
                        $mpdf->WriteHTML(view('hymns.patterns.print.' . $hymn->pattern_id, [ 'stanzas' => $preparedStanzas, 'pageNumber' => $pageNumber ])->render());
                        $html .= view('hymns.patterns.print.' . $hymn->pattern_id, [ 'stanzas' => $preparedStanzas, 'pageNumber' => $pageNumber ])->render();
                    } else {
                        $mpdf->WriteHTML(view('hymns.patterns.print.0', [ 'stanzas' => $preparedStanzas, 'pageNumber' => $pageNumber ])->render());
                        $html .= view('hymns.patterns.print.0', [ 'stanzas' => $preparedStanzas, 'pageNumber' => $pageNumber ])->render();
                    }

                    if (count($stanzas) == 0) {
                        $mpdf->WriteHTML(view('hinarios.print.hymn_footer', ['hymn' => $hymn])->render());
                        $html .= view('hinarios.print.hymn_footer', ['hymn' => $hymn])->render();
                    } else {
                        $mpdf->WriteHTML(view('hinarios.print.hymn_continued', ['hymn' => $hymn])->render());
                        $html .= view('hinarios.print.hymn_continued', ['hymn' => $hymn])->render();
                    }

                    if (count($stanzas) > 0) {
                        $pageNumber++;
                    }
                    $totalPageCount ++;
                }
            }
        }

        if (GlobalFunctions::getCurrentLanguage() == Languages::ENGLISH) {
            $printDate = date('F j, Y');
        } else {
            $printDate = date('d-m-Y');
        }

        $mpdf->setFooter('');
        $mpdf->WriteHTML(view('hinarios.print.final_page', [ 'printDate' => $printDate ])->render());
        $html .= view('hinarios.print.final_page')->render();

        $mpdf->Output();
        //echo $html;
    }

    public function showPdfPreloaded($hinarioId, $hinarioName)
    {
        $html = '';
        $hinario = Hinario::where('id', $hinarioId)->first();
        $hinarioData = json_decode($hinario->preloaded_json);

        $sections = $hinario->getSections();

        $hinarioHasTranslations = $hinario->hasTranslationsForLanguage(GlobalFunctions::getCurrentLanguage());

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [139, 216]]);

        $mpdf->WriteHTML(view('hinarios.print.title_page', [ 'hinario' => $hinario ])->render());
        $html .= view('hinarios.print.title_page', [ 'hinario' => $hinario ])->render();
        $totalPageCount = 2;

        $mpdf->setFooter('{PAGENO}');

        foreach ($sections as $section) {
            if (count($sections) > 1) {
                $mpdf->WriteHTML(view('hinarios.print.section_page', ['section' => $section])->render());
                $html .= view('hinarios.print.section_page', ['section' => $section])->render();
                $totalPageCount++;
            }

            foreach ($hinario->getHymnsForSection($section->section_number) as $hymn) {

                $stanzas = $hymn->stanzas($hymn->original_lanaguage_id);
                if ($hymn->original_language_id != GlobalFunctions::getCurrentLanguage()) {
                    $stanzas2 = $hymn->stanzas(GlobalFunctions::getCurrentLanguage());
                    if (!empty($stanzas2)) {
                        $hasTranslation = true;
                    } else {
                        $hasTranslation = false;
                    }
                } else {
                    $stanzas2 = [];
                    $hasTranslation = false;
                }

                if (($totalPageCount % 2) != 0 && count($stanzas2) > 0) {
                    $mpdf->WriteHTML(view('hinarios.print.blank_page')->render());
                    $totalPageCount++;
                }

                $pageNumber = 1;
                $loops = 0;

                // while we still have stanzas
                while (count($stanzas) > 0) {
                    $loops++;
                    $lineCount = 0;
                    $preparedStanzas = [];
                    $preparedStanzas2 = [];

                    // Walk through remaining stanzas checking to see it there's room to add them
                    for ($x = 0; $x < count($stanzas); $x++) {

                        // if there is room for the new stanza, add it
                        if ($lineCount + count($stanzas[$x]->getLines()) <= 29) {
                            $preparedStanzas[] = $stanzas[$x];
                            $lineCount += count($stanzas[$x]->getLines());
                            if ($x < (count($stanzas)-1)) {
                                $lineCount++;
                            }

                            if ($hasTranslation) {
                                if (!isset($stanzas2[$x])) {
                                    echo $x; die(print_r($stanzas2));
                                }
                                $preparedStanzas2[] = $stanzas2[$x];
                            }

                            // mamae o mamae
                            if (count($preparedStanzas) == 4 && $hymn->pattern_id == 46
                            ) {
                                $lineCount = 30;
                                $x = 1000;
                            }

                            // Joao Pereira #43
                            if ($hymn->pattern_id == 52 && count($preparedStanzas) == 5) {
                                $lineCount = 30;
                                $x = 1000;
                            }

                            // hymn patterns that require starting each page on an even number
                            if (in_array($hymn->pattern_id, [48, 52, 70]) && (count($preparedStanzas) % 4 == 0)) {
                                $lineCount = 30;
                                $x = 1000;
                            }

                        } else {
                            $x = 1000;
                            $lineCount = 1000;
                        }

                    }

                    // remove the prepared stanzas from the list
                    array_splice($stanzas, 0, count($preparedStanzas));
                    if ($hasTranslation) {
                        array_splice($stanzas2, 0, count($preparedStanzas2));
                    }

                    // translated page
                    if (count($preparedStanzas2) > 0) {

                        if ($pageNumber == 1) {
                            $mpdf->WriteHTML(view('hinarios.print.hymn_header', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => GlobalFunctions::getCurrentLanguage(), 'pageCount' => $totalPageCount])->render());
                            $html .= view('hinarios.print.hymn_header', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => GlobalFunctions::getCurrentLanguage(), 'pageCount' => $totalPageCount])->render();
                        } else {
                            $mpdf->WriteHTML(view('hinarios.print.hymn_header_continued', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => GlobalFunctions::getCurrentLanguage(), 'pageCount' => $totalPageCount])->render());
                            $html .= view('hinarios.print.hymn_header_continued', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => GlobalFunctions::getCurrentLanguage(), 'pageCount' => $totalPageCount])->render();
                        }

                        if (view()->exists('hymns.patterns.print.' . $hymn->pattern_id)) {
                            $mpdf->WriteHTML(view('hymns.patterns.print.' . $hymn->pattern_id, [ 'stanzas' => $preparedStanzas2, 'pageNumber' => $pageNumber ])->render());
                            $html .= view('hymns.patterns.print.' . $hymn->pattern_id, [ 'stanzas' => $preparedStanzas2, 'pageNumber' => $pageNumber ])->render();
                        } else {
                            $mpdf->WriteHTML(view('hymns.patterns.print.0', [ 'stanzas' => $preparedStanzas2, 'pageNumber' => $pageNumber ])->render());
                            $html .= view('hymns.patterns.print.0', [ 'stanzas' => $preparedStanzas2, 'pageNumber' => $pageNumber ])->render();
                        }

                        if (count($stanzas2) == 0) {
                            $mpdf->WriteHTML(view('hinarios.print.hymn_footer', ['hymn' => $hymn])->render());
                            $html .= view('hinarios.print.hymn_footer', ['hymn' => $hymn])->render();
                        } else {
                            $mpdf->WriteHTML(view('hinarios.print.hymn_continued', ['hymn' => $hymn])->render());
                            $html .= view('hinarios.print.hymn_continued', ['hymn' => $hymn])->render();
                        }

                        $totalPageCount++;
                    }

                    // page header - original language
                    if ($pageNumber == 1) {
                        $mpdf->WriteHTML(view('hinarios.print.hymn_header', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => $hinario->original_language_id, 'pageCount' => $totalPageCount ])->render());
                        $html .= view('hinarios.print.hymn_header', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => $hinario->original_language_id, 'pageCount' => $totalPageCount])->render();
                    } else {
                        $mpdf->WriteHTML(view('hinarios.print.hymn_header_continued', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => $hinario->original_language_id, 'pageCount' => $totalPageCount])->render());
                        $html .= view('hinarios.print.hymn_header_continued', ['hymn' => $hymn, 'hinario' => $hinario, 'language' => $hinario->original_language_id, 'pageCount' => $totalPageCount])->render();
                    }

                    // first page
                    if (view()->exists('hymns.patterns.print.' . $hymn->pattern_id)) {
                        $mpdf->WriteHTML(view('hymns.patterns.print.' . $hymn->pattern_id, [ 'stanzas' => $preparedStanzas, 'pageNumber' => $pageNumber ])->render());
                        $html .= view('hymns.patterns.print.' . $hymn->pattern_id, [ 'stanzas' => $preparedStanzas, 'pageNumber' => $pageNumber ])->render();
                    } else {
                        $mpdf->WriteHTML(view('hymns.patterns.print.0', [ 'stanzas' => $preparedStanzas, 'pageNumber' => $pageNumber ])->render());
                        $html .= view('hymns.patterns.print.0', [ 'stanzas' => $preparedStanzas, 'pageNumber' => $pageNumber ])->render();
                    }

                    if (count($stanzas) == 0) {
                        $mpdf->WriteHTML(view('hinarios.print.hymn_footer', ['hymn' => $hymn])->render());
                        $html .= view('hinarios.print.hymn_footer', ['hymn' => $hymn])->render();
                    } else {
                        $mpdf->WriteHTML(view('hinarios.print.hymn_continued', ['hymn' => $hymn])->render());
                        $html .= view('hinarios.print.hymn_continued', ['hymn' => $hymn])->render();
                    }

                    if (count($stanzas) > 0) {
                        $pageNumber++;
                    }
                    $totalPageCount ++;
                }
            }
        }

        if (GlobalFunctions::getCurrentLanguage() == Languages::ENGLISH) {
            $printDate = date('F j, Y');
        } else {
            $printDate = date('d-m-Y');
        }

        $mpdf->setFooter('');
        $mpdf->WriteHTML(view('hinarios.print.final_page', [ 'printDate' => $printDate ])->render());
        $html .= view('hinarios.print.final_page')->render();

        $mpdf->Output();
        //echo $html;
    }
}
