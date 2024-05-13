<?php
namespace App\Http\Controllers;

use App\Enums\Languages;
use App\Models\Hinario;
use App\Models\UserHinario;
use App\Models\UserHymnHinario;
use App\Services\GlobalFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class UserHinarioController extends Controller
{
    const IMAGE_FILE_ROOT = '/home/dh_nossa/nossairmandade.com/public';
    const IMAGE_URL_ROOT = '/images/userhinarios/';

    public function deleteUserHinario($hinarioId)
    {
        $userHinario = UserHinario::where('id', $hinarioId)->where('user_id', Auth::user()->getAuthIdentifier())->first();
        if (empty($userHinario)) {
            return back()->with('error', __('hinarios.personal.not_found'));
        }

        UserHymnHinario::where('hinario_id', $userHinario->id)->delete();
        $userHinario->delete();

        return back()->with('success', __('hinarios.personal.hinario_deleted_message'));
    }

    public function createUserHinario(Request $request)
    {
        if (empty($request->get('hinario_name'))) {
            return back()->with('error', __('hinarios.personal.create_hinario_name_missing'));
        }

        $userHinario = new UserHinario();
        $userHinario->name = $request->get('hinario_name');
        $userHinario->user_id = Auth::user()->getAuthIdentifier();
        $userHinario->code = GlobalFunctions::generateUserHinarioCode();
        $userHinario->save();

        return back()->with('success', __('hinarios.personal.hinario_created_message'));
    }

    public function editUserHinario($hinarioId)
    {
        $userHinario = UserHinario::where('id', $hinarioId)->where('user_id', Auth::user()->getAuthIdentifier())->first();
        if (empty($userHinario)) {
            return back()->with('error', __('hinarios.personal.not_found'));
        }

        return view('hinarios.edit_personal', [ 'hinario' => $userHinario ]);
    }

    public function saveUserHinario(Request $request, $hinarioId)
    {
        $userHinario = UserHinario::where('id', $hinarioId)->where('user_id', Auth::user()->getAuthIdentifier())->first();
        if (empty($userHinario)) {
            return back();
        }

        switch ($request->get('action')) {

            case 'rename_hinario':
                $userHinario->name = $request->get('new_name');
                $userHinario->save();

                return back();
                break;

            case 'new_image':
                // $imageDir = self::IMAGE_FILE_ROOT . self::IMAGE_URL_ROOT . $userHinario->id .'/';
                $imageDir = str_replace('\\', '/', public_path('images/userhinarios/'. $userHinario->id .'/'));
                
                if (!file_exists($imageDir)) {
                    mkdir($imageDir,'0775',true);
                }
                $this->deleteFiles($imageDir);
                
                $location = $imageDir . basename($_FILES['new_image']['name']);
                
                move_uploaded_file($_FILES['new_image']['tmp_name'], $location);
                $userHinario->image_path = self::IMAGE_URL_ROOT . $userHinario->id . '/' . basename($_FILES['new_image']['name']);
                $userHinario->save();

                return back();
                break;

            case 'delete_hymn':
                $userHymnHinarios = UserHymnHinario::where('hinario_id', $hinarioId)->orderBy('list_order')->get();

                $found = false;
                $renumber = false;
                foreach ($userHymnHinarios as $userHymnHinario) {
                    if ($userHymnHinario->hymn_id == $request->get('hymn_id')) {
                        $found = true;
                        $userHymnHinario->delete();
                    }

                    if ($found && $renumber) {
                        if ($renumber) {
                            $userHymnHinario->list_order = $userHymnHinario->list_order - 1;
                            $userHymnHinario->save();
                        }
                    }

                    if ($found) {
                        $renumber = true;
                    }
                }

                return back();
                break;

            case 'move_up':

                $userHymnHinario = UserHymnHinario::where('hinario_id', $hinarioId)->where('hymn_id', $request->get('hymn_id'))->first();
                $toMoveDown = UserHymnHinario::where('hinario_id', $hinarioId)->where('list_order', $userHymnHinario->list_order - 1)->first();
                $userHymnHinario->list_order -= 1;
                $toMoveDown->list_order += 1;
                $userHymnHinario->save();
                $toMoveDown->save();

                return back();

            case 'move_down':

                $userHymnHinario = UserHymnHinario::where('hinario_id', $hinarioId)->where('hymn_id', $request->get('hymn_id'))->first();
                $toMoveDown = UserHymnHinario::where('hinario_id', $hinarioId)->where('list_order', $userHymnHinario->list_order + 1)->first();
                $userHymnHinario->list_order += 1;
                $toMoveDown->list_order -= 1;
                $userHymnHinario->save();
                $toMoveDown->save();

                return back();
            default:
                return back();
        }
    }

    private function deleteFiles($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                $this->deleteFiles( $file );
            }
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }

    public function showPdf($code)
    {
        $html = '';

        $hinario = UserHinario::where('code', $code)
            ->with(
                'hymns',
                'hymnHinarios',
                'hymnHinarios.hinario',
                'hymns.translations',
                'hymns.hymnHinarios',
                'hymns.notationTranslations'
            )
            ->first();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [139, 216]]);

        $mpdf->WriteHTML(view('hinarios.print.title_page', [ 'hinario' => $hinario ])->render());
        $html .= view('hinarios.print.title_page', [ 'hinario' => $hinario ])->render();
        $totalPageCount = 2;

        foreach ($hinario->hymns as $hymn) {

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

        if (GlobalFunctions::getCurrentLanguage() == Languages::ENGLISH) {
            $printDate = date('F j, Y');
        } else {
            $printDate = date('d-m-Y');
        }

        $mpdf->setFooter('');
        $mpdf->WriteHTML(view('hinarios.print.final_page', [ 'printDate' => $printDate ])->render());
        $html .= view('hinarios.print.final_page', [ 'printDate' => $printDate ])->render();

        $mpdf->Output();
        //echo $html;
    }

    public function showPdfPreloaded($code)
    {
        $html = '';

        $hinario = UserHinario::where('code', $code)
            ->with(
                'hymns',
                'hymnHinarios',
                'hymnHinarios.hinario',
                'hymns.translations',
                'hymns.hymnHinarios',
                'hymns.notationTranslations'
            )
            ->first();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [139, 216]]);

        $mpdf->WriteHTML(view('hinarios.print.title_page', [ 'hinario' => $hinario ])->render());
        $html .= view('hinarios.print.title_page', [ 'hinario' => $hinario ])->render();
        $totalPageCount = 2;

        foreach ($hinario->hymns as $hymn) {

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

        if (GlobalFunctions::getCurrentLanguage() == Languages::ENGLISH) {
            $printDate = date('F j, Y');
        } else {
            $printDate = date('d-m-Y');
        }

        $mpdf->setFooter('');
        $mpdf->WriteHTML(view('hinarios.print.final_page', [ 'printDate' => $printDate ])->render());
        $html .= view('hinarios.print.final_page', [ 'printDate' => $printDate ])->render();

        $mpdf->Output();
        //echo $html;
    }
}
