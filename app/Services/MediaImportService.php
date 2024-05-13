<?php
namespace App\Services;

use App\Enums\HinarioTypes;
use App\Enums\MediaTypes;
use App\Models\Hinario;
use App\Models\HinarioMediaFile;
use App\Models\Hymn;
use App\Models\HymnMediaFile;
use App\Models\MediaFile;
use App\Models\MediaFileImportMessage;
// use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class MediaImportService
{
    public function importOldNossaPersonHymns($personId, $timeStamp)
    {
        // root path of old hymns
        $oldHymnsPath = '/home/dh_nossa/old_media/audio/';

        // path to the old hymns for the person we are importing
        $oldPersonPath = $oldHymnsPath . $personId;

        if (!file_exists($oldPersonPath)) {
            return;
        }

        // path to where hymns live in the new world
        $newHymnsRootPath = '/home/dh_nossa/nossairmandade.com/public/media/hymns/';

        $mediaSources = scandir($oldPersonPath);
        foreach ($mediaSources as $mediaSource) {

            // path to the directory we are going to import
            $oldMediaPersonSourcePath = $oldPersonPath . '/' . $mediaSource;
            if (is_file($mediaSource)) {
                $message = new MediaFileImportMessage();
                $message->import_date = $timeStamp;
                $message->person_id = $personId;
                $message->old_file = utf8_encode($mediaSource);
                $message->message = 'Expecting directory, found file.';
                $message->save();

                continue;
            } elseif ($mediaSource == '.' || $mediaSource == '..') {
                continue;
            }

            try {
                $files = scandir($oldMediaPersonSourcePath);
            } catch (\Exception $exception) {
                $message = new MediaFileImportMessage();
                $message->import_date = $timeStamp;
                $message->person_id = $personId;
                $message->old_file = utf8_encode($mediaSource);
                $message->message = 'Could not scandir ' . $oldMediaPersonSourcePath ;
                $message->save();

                continue;
            }
            foreach ($files as $file) {
                // path to the old file we are going to import
                $oldFilePath = $oldMediaPersonSourcePath . '/' . $file;
                if ($file == '.' || $file == '..') {
                    continue;
                }

                try {
                    $parts = explode(' ', $file); // parts of the filename
                    $chunks = explode('.', $file); // get file extension

                    $hymnId = $parts[1];
                    $fileExtension = $chunks[1];
                } catch (\Exception $exception) {
                    $message = new MediaFileImportMessage();
                    $message->import_date = $timeStamp;
                    $message->person_id = $personId;
                    $message->source_id = $mediaSource;
                    $message->old_file = utf8_encode($file);
                    $message->message = 'File name not parseable';
                    $message->save();

                    continue;
                }

                // destination path for the file
                $newHymnSourcePath = $newHymnsRootPath . $hymnId . '/' . $mediaSource;

                $hymn = Hymn::where('id', $hymnId)->first();

                if (empty($hymn)) {
                    continue;
                }

                // new name for the file
                $name = $this->getHymnFileName($hymn, $fileExtension, $newHymnSourcePath);

                // if the file exists from the source and the source is not Unknown - skip it
                if ($mediaSource != -1 && file_exists($newHymnSourcePath . '/' . $name)) {
                    $message = new MediaFileImportMessage();
                    $message->import_date = $timeStamp;
                    $message->person_id = $personId;
                    $message->source_id = $mediaSource;
                    $message->old_file = utf8_encode($file);
                    $message->message = 'File already exists';
                    $message->save();

                    continue;
                }

                if (!file_exists($newHymnsRootPath)) {
                    mkdir($newHymnsRootPath);
                }

                if (!file_exists($newHymnsRootPath . $hymnId)) {
                    mkdir($newHymnsRootPath . $hymnId);
                }

                if (!file_exists($newHymnsRootPath . $hymnId . '/' . $mediaSource)) {
                    mkdir($newHymnsRootPath . $hymnId . '/' . $mediaSource);
                }

                copy(
                    $oldFilePath,
                    $newHymnsRootPath . $hymnId . '/' . $mediaSource . '/' . $name
                );

                $mediaFile = new MediaFile();
                $mediaFile->media_source_id = $mediaSource;
                $mediaFile->path = $newHymnsRootPath . $hymnId . '/' . $mediaSource . '/';
                $mediaFile->media_type_id = MediaTypes::AUDIO;
                $mediaFile->filename = utf8_encode($name);
                $mediaFile->url = '/media/hymns/' . $hymnId . '/' . $mediaSource .'/' . utf8_encode($name);
                $mediaFile->save();

                $hymnMediaFile = new HymnMediaFile();
                $hymnMediaFile->hymn_id = $hymnId;
                $hymnMediaFile->media_file_id = $mediaFile->id;
                $hymnMediaFile->save();
            }
        }

        Log::debug(
            'Imported a person',
            [
                'personId' => $personId
            ]
        );
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
            $name = $number . $hymn->getName() . ' ' . $count;
            $count++;
        }

        $name .= '.' . $fileExtension;

        return $name;
    }

    public function generateHinarioRecordingsZips($hinarioId)
    {
        // $hinarioFileRoot = '/home/dh_nossa/nossairmandade.com/public/media/hinarios/';
        $hinarioFileRoot = base_path() . '/public/media/hinarios/';
        // dd($hinarioFileRoot);

        $files = [];
        $hinario = Hinario::where('id', $hinarioId)
            ->with('hymns', 'hymns.mediaFiles', 'hymns.mediaFiles.source', 'hymns.mediaFiles.upvotes')
            ->first();

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
}
