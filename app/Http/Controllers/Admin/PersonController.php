<?php
namespace App\Http\Controllers\Admin;

use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Person;
use App\Models\Image;
use App\Models\PersonImage;
use App\Models\PersonTranslation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const IMAGE_FILE_ROOT = '/home/dh_nossa/nossairmandade.com/public';
    const IMAGE_URL_ROOT = '/images/persons/';

    private $personData;

    public function __construct()
    {
        $this->personData = [
            'personId' => 0,
            'display_name' => '',
            'full_name' => '',
            'searchable' => 0,
            'englishDescription' => '',
            'portugueseDescription' => '',
            'personImages' => [],
            'persons' => [],
            'feedback' => [],
        ];
    }

    public function show()
    {
        $this->personData['persons'] = $this->loadPersons();

        return view('admin.edit_person', $this->personData);
    }

    public function save(Request $request)
    {
        $person = Person::where('id', $request->get('personId'))->first();

        if ($request->get('action') == 'load') {
            $this->loadPersonAndPrepareVariables($person);
        } elseif ($request->get('action') == 'feedback') {
            $this->handleFeedback($request->get('feedback_id'));
            $this->loadPersonAndPrepareVariables($person);
        } elseif ($request->get('action') == 'delete_image') {
            $this->deleteImage($request->get('image_id'));
            $this->loadPersonAndPrepareVariables($person);
        } elseif ($request->get('action') == 'set_portrait') {
            $this->setPortrait($request->get('image_id'));
            $this->loadPersonAndPrepareVariables($person);
        } else {
            $this->savePersonAndPrepareVariables($request->all(), $person);
        }

        return view('admin.edit_person', $this->personData);
    }

    public function load()
    {
        return view('admin.load_hymn');
    }

    private function loadPersons()
    {
        $persons = Person::orderBy('display_name')->get();
        return $persons;
    }

    private function deleteImage($imageId)
    {
        $image = Image::where('id', $imageId);
        $personImage = PersonImage::where('image_id', $imageId)->first();
        $allPersonImages = PersonImage::where('person_id', $personImage->person_id)->get();
        if (!empty($image)) {
            if ($personImage->is_portrait == 1) {
                // for now just assign some other random
                foreach($allPersonImages as $otherPersonImage) {
                    if ($otherPersonImage->image_id != $imageId) {
                        $otherPersonImage->is_portrait = 1;
                        $otherPersonImage->save();
                        break;
                    }
                }
            }

            $image->delete();
            $personImage->delete();
        }
    }

    private function setPortrait($imageId)
    {
        $personImage = PersonImage::where('image_id', $imageId)->first();
        $personImages = PersonImage::where('person_id', $personImage->person_id)->get();
        foreach($personImages as $personImage) {
            if ($personImage->image_id != $imageId) {
                $personImage->is_portrait = 0;
                $personImage->save();
            } else {
                $personImage->is_portrait = 1;
                $personImage->save();
            }
        }
    }

    private function handleFeedback($feedbackId)
    {
        $feedback = Feedback::where('id', $feedbackId)->first();
        $feedback->resolved = 1;
        $feedback->save();
    }

    private function savePersonAndPrepareVariables($requestParams, Person $person)
    {
        $person->display_name = $requestParams['display_name'];
        $person->full_name = $requestParams['full_name'];
        $person->save();

        $english = $person->getTranslation(Languages::ENGLISH);
        if (empty($english)) {
            $english = new PersonTranslation();
            $english->language_id = Languages::ENGLISH;
            $english->person_id = $person->id;
        }
        $english->description = $requestParams['english_description'];
        $english->save();

        $portuguese = $person->getTranslation(Languages::PORTUGUESE);
        if (empty($portuguese)) {
            $portuguese = new PersonTranslation();
            $portuguese->language_id = Languages::PORTUGUESE;
            $portuguese->person_id = $person->id;
        }
        $portuguese->description = $requestParams['portuguese_description'];
        $portuguese->save();

        // image
        if (isset($requestParams['new_image']) && $requestParams['new_image'] != '') {
            $imageDir = self::IMAGE_FILE_ROOT . self::IMAGE_URL_ROOT . $person->id;
            if (!file_exists($imageDir)) {
                mkdir($imageDir);
            }
            $location = $imageDir . '/' . basename($_FILES['new_image']['name']);

            move_uploaded_file($_FILES['new_image']['tmp_name'], $location);

            $image = new Image();
            $image->path = self::IMAGE_URL_ROOT . $person->id . '/' . basename($_FILES['new_image']['name']);;
            $image->save();

            $personImage = new PersonImage();
            $personImage->person_id = $person->id;
            $personImage->image_id = $image->id;
            $personImage->save();
        }

        $person->refresh();

        $this->loadPersonAndPrepareVariables($person);
    }

    private function loadPersonAndPrepareVariables(Person $person)
    {
        $this->personData['persons'] = $this->loadPersons();

        // person
        $this->personData['personId'] = $person->id;
        $this->personData['displayName'] = $person->display_name;
        $this->personData['fullName'] = $person->full_name;
        $this->personData['searchable'] = $person->searchable;

        // person_translation
        $this->personData['englishDescription'] = $person->getDescription(Languages::ENGLISH);
        $this->personData['portugueseDescription'] = $person->getDescription(Languages::PORTUGUESE);

        // images
        $this->personData['personImages'] = $person->personImages;

        // feedback
        $this->personData['feedback'] = $person->feedback;
    }
}
