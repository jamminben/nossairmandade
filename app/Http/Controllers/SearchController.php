<?php
namespace App\Http\Controllers;

use App\Models\HymnTranslation;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function advanced(Request $request)
    {
        $hymnTranslationsQuery = HymnTranslation::where('hymn_translations.id', '>', 0);
        $run = false;
        $contains = $this->sanitizeSearchTerms($request->get('hymn_contains'));

        $receivedBy = $request->get('received_by', '');
        // dd($receivedBy);
        $offeredTo = $request->get('offered_to', '');

        if (!empty($request->get('hymn_contains'))) {
            $hymnTranslationsQuery->whereRaw('MATCH (name, lyrics) AGAINST (?)' , $request->get('hymn_contains'));
            $run = true;
        }
        if (!empty($request->get('received_by'))) {
            $hymnTranslationsQuery->join('hymns', 'hymn_translations.hymn_id', '=', 'hymns.id')
                ->where('hymns.received_by', $request->get('received_by'));
            $run = true;
        }
        if (!empty($request->get('offered_to'))) {
            $hymnTranslationsQuery->join('hymns', 'hymn_translations.hymn_id', '=', 'hymns.id')
                ->where('hymns.offered_to', $request->get('offered_to'));
            $run = true;
        }

        if ($run) {
            $hymnTranslations = $hymnTranslationsQuery->paginate(20);
        } else {
            $hymnTranslations = collect( [] );
        }

        $people = Person::leftJoin('hymns', 'received_by', '=', 'persons.id')
            ->groupBy(['persons.display_name', 'persons.id'])
            ->select('persons.id', 'display_name', DB::raw('count(hymns.id) as hymns_count'))
            ->orderBy('display_name')
            ->get();

        return view('advanced_search', [
            'people' => $people,
            'hymnTranslations' => $hymnTranslations,
            'contains' => $contains,
            'receivedBy' => $receivedBy,
            'offeredTo' => $offeredTo
        ]);
    }

    public function advanced_livewire() {

        return view('advanced_search_livewire');
    }

    private function sanitizeSearchTerms($string)
    {
        $clean = strip_tags($string);
        $badCharacters = [
            '\'',
            ';',
            ',',
            '.',
            '(',
            ')',
            '<',
            '>',
            '{',
            '}',
            '[',
            ']',
            '!',
            '=',
            '-',
            '_',
            '@',
            '#',
            '$',
            '%',
            '^',
            '&',
            '*',
            '`',
            '~',
            '/',
            '\\',
            '?',
        ];
        $clean = str_replace($badCharacters, '', $clean);

        return $clean;
    }
}
