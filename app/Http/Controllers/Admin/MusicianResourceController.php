<?php
namespace App\Http\Controllers\Admin;

use App\Enums\Languages;
use App\Enums\MediaTypes;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\MediaFile;
use App\Models\MusicianMediaFile;
use App\Models\Person;
use App\Models\Image;
use App\Models\PersonImage;
use App\Models\PersonTranslation;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MusicianResourceController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const FILE_ROOT = '/home/dh_nossa/nossairmandade.com/public';
    const URL_ROOT = '/media/musicians/';

    public function show()
    {
        $files = MusicianMediaFile::with('mediaFile')->get();

        return view('admin.edit_musician_files', [ 'files' => $files ]);
    }

    private function unlinkResource($resourceId)
    {
        $resource = MusicianMediaFile::where('id', $resourceId);
        $resource->delete();
    }

    public function save(Request $request)
    {
        if ($request->get('action') == 'save') {
            $this->saveFile($request);
        } elseif ($request->get('action') == 'delete') {
            $this->unlinkResource($request->get('file_id'));
        }

        $files = MusicianMediaFile::with('mediaFile')->get();

        return view('admin.edit_musician_files', ['files' => $files]);
    }

    private function saveFile(Request $request)
    {
        $requestParams = $request->all();
        if (isset($requestParams['new_file']) && $requestParams['new_file'] != '') {
            $fileDir = self::FILE_ROOT . self::URL_ROOT;
            if (!file_exists($fileDir)) {
                mkdir($fileDir);
            }
            $location = $fileDir . '/' . basename($_FILES['new_file']['name']);

            move_uploaded_file($_FILES['new_file']['tmp_name'], $location);

            $mediaFile = new MediaFile();
            $mediaFile->path = $location;
            $mediaFile->url = self::URL_ROOT . basename($_FILES['new_file']['name']);
            $mediaFile->filename = basename($_FILES['new_file']['name']);
            $mediaFile->media_type_id = $this->getMediaType(basename($_FILES['new_file']['name']));
            $mediaFile->save();

            $musicianMediaFile = new MusicianMediaFile();
            $musicianMediaFile->media_file_id = $mediaFile->id;
            $musicianMediaFile->save();
        }
    }

    private function getMediaType($filename)
    {
        $chunks = explode('.', $filename); // get file extension

        $fileExtension = $chunks[1];

        switch (strtolower($fileExtension)) {
            case 'pdf':
                return MediaTypes::PDF;
                break;
            case 'zip':
                return MediaTypes::ZIP;
                break;
            case 'doc':
                return MediaTypes::DOC;
                break;
            case '.jpg':
            case 'png':
            case 'jpeg':
                return MediaTypes::IMG;
                break;
            case 'mp3':
            case 'mpeg':
                return MediaTypes::AUDIO;
                break;
            default:
                return 0;
        }
    }
}
