<?php

namespace App\Http\Livewire;

use App\Models\HymnTranslation;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Search extends Component
{

    
    public $contains; //THE SEARCH TERM
    public $people = [];
    public $hymnTranslations = [];
    public $people_received = [];
    public $people_offered = [];

    public $receivedBy;
    public $offeredTo;

    public function mount() {
        $this->contains = request()->get('hymn_contains');
        $this->receivedBy = request()->get('received_by');
        $this->offeredTo = request()->get('offered_to');


        //ONLY LOADS ON PAGE LOAD
        //IF YOU WANT THIS TO RUN DYNAMICALLY, MOVE IT TO render() AND MOVE THE PORTION ON THE VIEW TO A COMPONENT
        $hymnTranslationsQuery = HymnTranslation::where('hymn_translations.id', '>', 0);
        $run = false;

        if ($this->contains) {
            $hymnTranslationsQuery->whereRaw('MATCH (name, lyrics) AGAINST (?)' , $this->contains);
            $run = true;
        }
        if ($this->receivedBy) {
            $hymnTranslationsQuery->join('hymns', 'hymn_translations.hymn_id', '=', 'hymns.id')
                ->where('hymns.received_by', $this->receivedBy);
            $run = true;
        }
        if ($this->offeredTo) {
            $hymnTranslationsQuery->join('hymns as h', 'hymn_translations.hymn_id', '=', 'h.id')
                ->where('hymns.offered_to', $this->offeredTo);
            $run = true;
        }

        // Log::info(__FILE__.":".__LINE__);
        // Log::info('run - ' . $run);

        if ($run) {
            // $hymnTranslations = $hymnTranslationsQuery->paginate(20);
            //LIVEWIRE DOESN'T WORK READILY WITH PAGINATE
            $hymnTranslations = $hymnTranslationsQuery->get();
            // Log::info($hymnTranslations);
        } else {
            $hymnTranslations = collect( [] );
        }
        $this->hymnTranslations = $hymnTranslations;

    }

    public function render()
    {

        $people_received = Person::leftJoin('hymns', 'received_by', '=', 'persons.id')
        ->groupBy(['persons.display_name', 'persons.id'])
        ->select('persons.id', 'display_name', DB::raw('count(hymns.id) as hymns_count'))
        ->having('hymns_count', '>', '0')
        ->orderBy('display_name');
        if ($this->offeredTo) {
            $people_received = $people_received->where('hymns.offered_to', '=', $this->offeredTo);
        }
        $people_received = $people_received->get();

        $this->people_received = $people_received;

        $people_offered = Person::leftJoin('hymns', 'offered_to', '=', 'persons.id')
        ->groupBy(['persons.display_name', 'persons.id'])
        ->select('persons.id', 'display_name', DB::raw('count(hymns.id) as hymns_count'))
        ->having('hymns_count', '>', '0')
        ->orderBy('display_name');
        if ($this->receivedBy) {
            $people_offered = $people_offered->where('hymns.received_by', '=', $this->receivedBy);
        }
        $people_offered = $people_offered->get();

        $this->people_offered = $people_offered;

        return view('livewire.search');
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
