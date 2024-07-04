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

    public function getIdFromDisplayName($name, bool $createNewIfMissing)
    {
        $person = Person::where('display_name', $name)->first();
        if (empty($person)) {
            if ($createNewIfMissing) {
                $person = new Person();
                $person->display_name = $name;
                $person->full_name = $name;
                $person->searchable = 0;
                $person->save();
                return $person->id;
            } else {
                return null;
            }
        } else {
            return $person->id;
        }
    }
}
