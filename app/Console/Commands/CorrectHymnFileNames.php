<?php

namespace App\Console\Commands;

use App\Models\Hymn;
use Illuminate\Console\Command;

class CorrectHymnFileNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hymns:correct_file_names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make sure hymn filenames are correct';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $hymns = Hymn::orderBy('id')->with('translations', 'mediaFiles', 'mediaFiles.source')->get();

        foreach ($hymns as $hymn) {
            foreach ($hymn->mediaFiles as $mediaFile) {
                $name = $mediaFile->filename;
                $name = mb_convert_encoding($name, 'ISO-8859-1');
                $url = $mediaFile->url;
                $url = mb_convert_encoding($url, 'ISO-8859-1');
                $mediaFile->filename = $name;
                $mediaFile->url = $url;
                $mediaFile->save();
            }
        }
    }
}
