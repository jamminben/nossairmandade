<?php
namespace App\Http\Controllers\Admin;

use App\Enums\EntityTypes;
use App\Enums\HinarioTypes;
use App\Enums\Languages;
use App\Enums\MediaTypes;
use App\Http\Controllers\Controller;
use App\Models\Hinario;
use App\Models\HinarioMediaFile;
use App\Models\Hymn;
use App\Models\HymnMediaFile;
use App\Models\MediaFile;
use App\Models\MediaSource;
use App\Models\MediaSourceTranslation;
use App\Models\PersonMediaFile;
// use Chumper\Zipper\Facades\Zipper;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use ZipArchive;

class MediaImportController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addMedia(Request $request)
    {
        $newFile = $request->get('new_media');

        // need a source
        if (empty($request->get('source_id')) && empty($request->get('new_source_description'))) {
            return back();
        }

        // make the source if needed
        $source = MediaSource::where('id', $request->get('source_id'))->first();
        if (empty($source)) {
            $sourceId = $this->makeNewSource($request->get('new_source_description'), $request->get('new_source_url'));
        } else {
            $sourceId = $request->get('source_id');
        }

        switch ($request->get('entity_type')) {
            case EntityTypes::HYMN:
                $this->addMediaToHymn($request->get('entity_id'), $sourceId);
                break;
            case EntityTypes::HINARIO:
                $this->addMediaToHinario($request->get('entity_id'), $sourceId);
                break;
            case EntityTypes::PERSON:
                $this->addMediaToPerson($request->get('entity_id'), $sourceId);
                break;
        }

        return back();
    }

    private function makeNewSource($description, $url)
    {
        $source = new MediaSource();
        $source->url = $url;
        $source->save();

        $sourceTranslation = new MediaSourceTranslation();
        $sourceTranslation->media_source_id = $source->id;
        $sourceTranslation->language_id = Languages::ENGLISH;
        $sourceTranslation->description = $description;
        $sourceTranslation->save();

        return $source->id;
    }

    private function addMediaToHymn($hymnId, $sourceId)
    {
        // $destinationRoot = '/home/dh_nossa/nossairmandade.com/public/media/hymns/';
        $destinationRoot = public_path('media/hymns/');

        $uploadFile = $_FILES['new_media']['tmp_name'];
        $oldName = $_FILES['new_media']['name'];

        if (!file_exists($destinationRoot . $hymnId)) {
            mkdir($destinationRoot . $hymnId);
        }
        if (!file_exists($destinationRoot . $hymnId .'/' .$sourceId)) {
            mkdir($destinationRoot . $hymnId .'/' .$sourceId);
        }
        
        copy($uploadFile, $destinationRoot . $hymnId . '/' . $sourceId . '/' . $oldName);

        $mediaFile = new MediaFile();
        $mediaFile->media_source_id = $sourceId;
        $mediaFile->path = $destinationRoot . $hymnId . '/' . $sourceId . '/' . $oldName;
        $mediaFile->media_type_id = $this->getMediaType($oldName);
        $mediaFile->filename = $oldName;
        $mediaFile->url = '/media/hymns/' . $hymnId . '/' . $sourceId .'/' . $oldName;
        $mediaFile->save();

        $hymnMediaFile = new HymnMediaFile();
        $hymnMediaFile->hymn_id = $hymnId;
        $hymnMediaFile->media_file_id = $mediaFile->id;
        $hymnMediaFile->save();
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

    private function addMediaToHinario($hinarioId, $sourceId)
    {
        // $destinationRoot = '/home/dh_nossa/nossairmandade.com/public/media/hinarios/';
        $destinationRoot = str_replace('/', '\\', public_path('media/hinarios/'));

        $uploadFile = $_FILES['new_media']['tmp_name'];
        $oldName = $_FILES['new_media']['name'];
        if (!file_exists($destinationRoot . $hinarioId)) {
            mkdir($destinationRoot . $hinarioId,'0755',true);
        }
        if (!file_exists($destinationRoot . $hinarioId .'/' .$sourceId)) {
            mkdir($destinationRoot . $hinarioId .'/' .$sourceId);
        }

        copy($uploadFile, $destinationRoot . $hinarioId . '/' . $sourceId . '/' . $oldName);
        $mediaFile = new MediaFile();
        $mediaFile->media_source_id = $sourceId;
        $mediaFile->path = $destinationRoot . $hinarioId . '/' . $sourceId . '/' . $oldName;
        $mediaFile->media_type_id = $this->getMediaType($oldName);
        $mediaFile->filename = $oldName;
        $mediaFile->url = '/media/hymns/' . $hinarioId . '/' . $sourceId .'/' . $oldName;
        $mediaFile->save();

        $hinarioMediaFile = new HinarioMediaFile();
        $hinarioMediaFile->hinario_id = $hinarioId;
        $hinarioMediaFile->media_file_id = $mediaFile->id;
        $hinarioMediaFile->save();
    }

    private function addMediaToPerson($personId, $sourceId)
    {
        $destinationRoot = '/home/dh_nossa/nossairmandade.com/public/media/people/';

        $uploadFile = $_FILES['new_media']['tmp_name'];
        $oldName = $_FILES['new_media']['name'];

        if (!file_exists($destinationRoot . $personId)) {
            mkdir($destinationRoot . $personId);
        }
        if (!file_exists($destinationRoot . $personId .'/' .$sourceId)) {
            mkdir($destinationRoot . $personId .'/' .$sourceId);
        }

        copy($uploadFile, $destinationRoot . $personId . '/' . $sourceId . '/' . $oldName);

        $mediaFile = new MediaFile();
        $mediaFile->media_source_id = $sourceId;
        $mediaFile->path = $destinationRoot . $personId . '/' . $sourceId . '/' . $oldName;
        $mediaFile->media_type_id = $this->getMediaType($oldName);
        $mediaFile->filename = $oldName;
        $mediaFile->url = '/media/hymns/' . $personId . '/' . $sourceId .'/' . $oldName;
        $mediaFile->save();

        $personMediaFile = new PersonMediaFile();
        $personMediaFile->person_id = $personId;
        $personMediaFile->media_file_id = $mediaFile->id;
        $personMediaFile->save();
    }

    private function getHymnFileName(Hymn $hymn, $fileExtension, $path)
    {
        if (empty($hymn)) {
            return '';
        }

        $number = '';
        if (!empty($hymn->received_order) && $hymn->received_order > 0) {
            $number = $hymn->received_order . ' ';
        }
        $name = $number . $hymn->getName();

        $count = 1;
        while (file_exists($path . $name)) {
            $name = $number . ' ' .$hymn->getName() . ' ' . $count;
            $count++;
        }

        $name = mb_convert_case($hymn->getName(), MB_CASE_UPPER, 'UTF-8');

        $name .= '.' . $fileExtension;

        return $name;
    }

    public function showGenerateHinarioRecordingsZips()
    {
        return view('admin.generate_hinario_zips_form');
    }

    public function generateHinarioRecordingsZips(Request $request)
    {
        $hinarioFileRoot = '/home/dh_nossa/nossairmandade.com/public/media/hinarios/';

        $files = [];
        $hinario = Hinario::where('id', '=', $request->get('hinario_id'))->with('hymns')->first();

        if ($hinario->type_id == HinarioTypes::INDIVIDUAL || $hinario->type_id == HinarioTypes::LOCAL) {
            foreach ($hinario->hymns as $hymn) {
                $mediaFiles = $hymn->mediaFiles;
                foreach ($mediaFiles as $mediaFile) {
                    $files[$mediaFile->source->id][] = $mediaFile;
                }
            }
        } else {
            foreach ($hinario->hymns as $hymn) {
                $recordings = $hymn->getRecordings();
                if (count($recordings) > 0) {
                    $files[-1][] = $hymn->getRecordings()[0];
                }
            }
        }

        foreach (array_keys($files) as $sourceId) {
            // don't make a zip for 1 file
            if (count($files[$sourceId]) == 1) {
                continue;
            }

            $filesToZip = [];
            foreach ($files[$sourceId] as $mediaFile) {
                $filesToZip[] = $mediaFile->path;
            }

            if (!file_exists($hinarioFileRoot . $hinario->id)) {
                mkdir($hinarioFileRoot . $hinario->id);
            }
            if (!file_exists($hinarioFileRoot . $hinario->id . '/' . $sourceId)) {
                mkdir($hinarioFileRoot . $hinario->id . '/' . $sourceId);
            }

            $zipFileName = $hinarioFileRoot . $hinario->id . '/' . $sourceId . '/' . $hinario->getName($hinario->original_language_id) . '.zip';
            if (file_exists($zipFileName)) {
                rename($zipFileName, $zipFileName . '.bak');
            }

            try {
                // $zipper = Zipper::make($zipFileName);
                // $zipper->add($filesToZip);
                // $zipper->close();

                $zip_archive = new ZipArchive;

                if ($zip_archive->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) 
                {
                    // loop the files result
                    foreach ($filesToZip as $key => $value) {
                        $relativeNameInZipFile = basename($value);
                        $zip_archive->addFile($value, $relativeNameInZipFile);
                    }
                    $zip_archive->close();
                }


                $mediaFile = MediaFile::where('path', $zipFileName)->first();
                if (empty($mediaFile)) {
                    // make data entries if it's a new file
                    $mediaFile = new MediaFile();
                    $mediaFile->path = $zipFileName;
                    $mediaFile->url = '/media/hinarios/' . $hinario->id . '/' . $sourceId . '/' . $hinario->getName($hinario->original_language_id) . '.zip';
                    $mediaFile->filename = $hinario->getName($hinario->original_language_id) . '.zip';
                    $mediaFile->media_source_id = $sourceId;
                    $mediaFile->media_type_id = MediaTypes::ZIP;
                    $mediaFile->save();

                    $hinarioMediaFile = new HinarioMediaFile();
                    $hinarioMediaFile->hinario_id = $hinario->id;
                    $hinarioMediaFile->media_file_id = $mediaFile->id;
                    $hinarioMediaFile->save();
                }
            } catch (Exception $exception) {
                if (file_exists($zipFileName . '.bak')) {
                    rename($zipFileName . '.bak', $zipFileName);
                }
            }
        }

        return view('admin.generate_hinario_zips_form');
    }

    public function moveHymns(Request $request)
    {
        $pathRoot = '/home/dh_nossa/old_media/audio';

        $destinationRoot = '/home/dh_nossa/nossairmandade.com/public/media/hymns/';

        if (empty($request->get('person_id'))) {
            $rootFolders = scandir($pathRoot);
        } else {
            $rootFolders = [ $request->get('person_id') ];
        }

        // these are person_ids in the old system
        foreach ($rootFolders as $rootFolder) {
            if ($rootFolder != '.' &&
                $rootFolder != '..' &&
                !is_file($pathRoot .'/' . $rootFolder)
            ) {
                $mediaSources = scandir($pathRoot .'/' . $rootFolder);

                foreach ($mediaSources as $mediaSource) {
                    if ($mediaSource != '.' &&
                        $mediaSource != '..' &&
                        !is_file($pathRoot .'/' . $rootFolder . '/' . $mediaSource)
                    ) {
                        $files = scandir($pathRoot .'/' . $rootFolder .'/' .$mediaSource);

                        foreach ($files as $file) {
                            if ($file != '.' &&
                                $file != '..' &&
                                is_file($pathRoot .'/' . $rootFolder . '/' . $mediaSource . '/' . $file)
                            ) {
                                try {
                                    $parts = explode(' ', $file); // parts of the filename
                                    $chunks = explode('.', $file); // get file extension

                                    $hymnId = $parts[1];
                                    $fileExtension = $chunks[1];
                                } catch (\Exception $exception) {
                                    continue;
                                }

                                $hymn = Hymn::where('id', $hymnId)->first();

                                if (empty($hymn)) {
                                    continue;
                                }

                                $name = $this->getHymnFileName($hymn, $fileExtension, $destinationRoot . $hymnId . '/' . $mediaSource . '/');

                                // if the file exists from the source and the source is not Unknown - skip it
                                if ($mediaSource != -1 && file_exists($destinationRoot . $hymnId . '/' . $mediaSource . '/' . $name)) {
                                    continue;
                                }

                                if (!file_exists($destinationRoot . $hymnId)) {
                                    mkdir($destinationRoot . $hymnId);
                                }

                                if (!file_exists($destinationRoot . $hymnId . '/' . $mediaSource)) {
                                    mkdir($destinationRoot . $hymnId . '/' . $mediaSource);
                                }

                                copy(
                                    $pathRoot .'/' . $rootFolder .'/' .$mediaSource . '/' . $file,
                                    $destinationRoot . $hymnId . '/' . $mediaSource . '/' . $name
                                );

                                $mediaFile = new MediaFile();
                                $mediaFile->media_source_id = $mediaSource;
                                $mediaFile->path = $destinationRoot . $hymnId . '/' . $mediaSource . '/' . $name;
                                $mediaFile->media_type_id = MediaTypes::AUDIO;
                                $mediaFile->filename = $name;
                                $mediaFile->url = '/media/hymns/' . $hymnId . '/' . $mediaSource .'/' . $name;
                                $mediaFile->save();

                                $hymnMediaFile = new HymnMediaFile();
                                $hymnMediaFile->hymn_id = $hymnId;
                                $hymnMediaFile->media_file_id = $mediaFile->id;
                                $hymnMediaFile->save();
                            }
                        }
                    }
                }
            }
        }

        return view('admin.move_hymns_form');
    }

    public function showMoveHymns()
    {
        return view('admin.move_hymns_form');
    }
}
