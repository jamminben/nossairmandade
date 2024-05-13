<?php
namespace App\Http\Controllers;

use App\Models\Person;
use App\Services\PersonService;

class PersonController extends Controller
{
    private $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function show($personId)
    {
        $person = Person::where('id', $personId)->first();

        return view('person', [ 'person' => $person ]);
    }
}
