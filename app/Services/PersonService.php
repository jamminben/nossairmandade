<?php
namespace App\Services;

use App\Models\Person;

class PersonService
{
    public function getIndividuals()
    {
        $individuals = Person::orderBy('display_name')->with('images')->with('hinarios')->get();

        return $individuals;
    }
}
