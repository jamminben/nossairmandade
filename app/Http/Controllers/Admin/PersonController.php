<?php
namespace App\Http\Controllers\Admin;

use App\Enums\Languages;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Hinario;
use App\Models\ImageTranslation;
use App\Models\LanguageTranslation;
use App\Models\Person;
use App\Models\Image;
use App\Models\PersonImage;
use App\Models\PersonTranslation;
use App\Models\PersonUpdateLog;
use App\Services\GlobalFunctions;
use App\Services\MediaImportService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const IMAGE_FILE_ROOT = '/home/dh_nossa/nossairmandade.com/public';
    const IMAGE_URL_ROOT = '/images/persons/';

    //const IMAGE_FILE_ROOT = '/Users/benjamintobias/Documents/Ben\'s Laptop/nossairmandade/public';
    //const IMAGE_URL_ROOT = '/images/persons/';

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

    private function loadLanguages()
    {
        $languages = LanguageTranslation::where('in_language_id', GlobalFunctions::getCurrentLanguage())->orderBy('language_id')->get();
        return $languages;
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

    public function loadPerson($personId)
    {
        $person = Person::find($personId);
        if (empty($person)) {
            return back();
        }
        if (is_null(Auth::user()) || !Auth::user()->canEditPerson($personId)) {
            return redirect()->to(url('person/' . $personId . '/' . $person->display_name));
        }

        return view('admin.persons.person',
            [
                'person' => $person,
                'languages' => $this->loadLanguages(),
            ]
        );
    }

    public function savePerson(Request $request)
    {
        $personId = $request->get('personId');

        $person = Person::where('id', $personId)->first();

        if (is_null(Auth::user()) || !Auth::user()->canEditPerson($personId)) {
            return redirect()->to(url('person/' . $personId . '/' . $person->display_name));
        }

        $this->savePersonEdit($request->all(), $person);

        return redirect()->to(url('person/' . $personId . '/' . $person->display_name));
    }

    private function savePersonEdit($requestParams, Person $person)
    {
        $oldVersion = [];
        $newVersion = [];

        // Display Name
        if ($requestParams['display_name'] != $person->display_name) {
            $oldVersion['display_name'] = $person->display_name;
            $newVersion['display_name'] = $requestParams['display_name'];
            $person->display_name = $requestParams['display_name'];
        }
        // Full Name
        if ($requestParams['full_name'] != $person->full_name) {
            $oldVersion['full_name'] = $person->full_name;
            $newVersion['full_name'] = $requestParams['full_name'];
            $person->full_name = $requestParams['full_name'];
        }
        // Original Description
        $originalDescription = $person->getDescription($requestParams['original_language_id']);
        if ($requestParams['original_description'] != $originalDescription) {
            $oldVersion['description'] = $originalDescription;
            $newVersion['description'] = $requestParams['original_description'];
            $translation = PersonTranslation::where('person_id', $person->id)->where('language_id', $requestParams['original_language_id'])->first();
            if (empty($translation)) {
                $translation = new PersonTranslation();
                $translation->person_id = $person->id;
                $translation->language_id = $requestParams['original_language_id'];
            }
            $translation->description = $requestParams['original_description'];
            $translation->save();
        }
        // Secondary Description
        if ($requestParams['secondary_language_id'] != 0) {
            $secondaryDescription = $person->getDescription($requestParams['secondary_language_id']);
            if ($requestParams['secondary_description'] != $secondaryDescription) {
                $oldVersion['secondary_description'] = $secondaryDescription;
                $newVersion['secondary_description'] = $requestParams['secondary_description'];
                $translation = PersonTranslation::where('person_id', $person->id)->where('language_id', $requestParams['secondary_language_id'])->first();
                if (empty($translation)) {
                    $translation = new PersonTranslation();
                    $translation->person_id = $person->id;
                    $translation->language_id = $requestParams['secondary_language_id'];
                }
                $translation->description = $requestParams['secondary_description'];
                $translation->save();
            }
        }

        $person->save();

        // New Image
        if (isset($requestParams['new_image']) && $requestParams['new_image'] != '') {
            $imageDir = public_path(self::IMAGE_URL_ROOT . $person->id);
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

            $imageTranslation = new ImageTranslation();
            $imageTranslation->image_id = $image->id;
            $imageTranslation->language_id = $requestParams['original_language_id'];
            $imageTranslation->caption = $person->display_name;
            $imageTranslation->save();

            $newVersion['images']['new_image'] = $personImage->id;
        }

        // Captions, set portrait, and deletes
        foreach ($person->personImages as $personImage) {
            // captions
            $primaryCaption = $personImage->image->getPrimaryTranslation();
            if (empty($primaryCaption)) {
                $primaryCaption = new ImageTranslation();
                $primaryCaption->image_id = $personImage->image->id;
                $primaryCaption->language_id = $requestParams['original_language_id'];
            }

            if (!empty($requestParams['image_caption_' . $personImage->image->id]) && $requestParams['image_caption_' . $personImage->image->id] != $primaryCaption->caption) {
                $oldVersion['image'][] = [
                    'image_id' => $personImage->image->id,
                    'caption' => $primaryCaption->caption,
                ];
                $newVersion['image'][] = [
                    'image_id' => $personImage->image->id,
                    'caption' => $requestParams['image_caption_' . $personImage->image->id],
                ];

                $primaryCaption->caption = $requestParams['image_caption_' . $personImage->image->id];
                $primaryCaption->save();
            }

            $secondaryCaptions = $personImage->image->getSecondaryTranslations();

            if (is_null($secondaryCaptions) || count($secondaryCaptions) == 0) {
                $secondaryCaption = new ImageTranslation();
                $secondaryCaption->image_id = $personImage->image->id;
                $secondaryCaption->language_id = $requestParams['secondary_language_id'];
            } else {
                print_r($secondaryCaptions); die();
                $secondaryCaption = $secondaryCaptions[0];
            }

            if (!empty($requestParams['secondary_image_caption_' . $personImage->image->id]) &&
                $requestParams['secondary_image_caption_' . $personImage->image->id] != $secondaryCaption->caption) {
                $oldVersion['image'][] = [
                    'image_id' => $personImage->image->id,
                    'secondary_caption' => $secondaryCaption->caption,
                ];
                $newVersion['image'][] = [
                    'image_id' => $personImage->image->id,
                    'secondary_caption' => $requestParams['secondary_image_caption_' . $personImage->image->id],
                ];

                $secondaryCaption->caption = $requestParams['secondary_image_caption_' . $personImage->image->id];
                $secondaryCaption->save();
            }

            // set portrait
            if (isset($requestParams['portrait']) && $requestParams['portrait'] == $personImage->image->id) {
                if ($personImage->is_portrait == 0) {
                    $newVersion['portrait'] = $personImage->id;
                    $personImage->is_portrait = 1;
                    $personImage->save();
                }
            } elseif (isset($requestParams['portrait'])) {
                if ($personImage->is_portrait == 1) {
                    $oldVersion['portrait'] = $personImage->id;
                    $personImage->is_portrait = 0;
                    $personImage->save();
                }
            }

            // delete
            if (!empty($requestParams['delete_image_' . $personImage->image->id])) {
                $personImage->delete();
                $newVersion['images']['delete'][] = $personImage->image->id;
            }
        }

        $personUpdateLog = new PersonUpdateLog();
        $personUpdateLog->person_id = $person->id;
        $personUpdateLog->updated_by = Auth::user()->id;
        $personUpdateLog->updated_at = date('Y-m-d H:i:s');
        $personUpdateLog->old_version = json_encode($oldVersion);
        $personUpdateLog->new_version = json_encode($newVersion);
        $personUpdateLog->save();
    }
}
