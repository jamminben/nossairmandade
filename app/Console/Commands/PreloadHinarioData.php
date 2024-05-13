<?php

namespace App\Console\Commands;

use App\Models\Hinario;
use App\Services\HinarioService;
use Illuminate\Console\Command;

class PreloadHinarioData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hinarios:preload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preload data for rendering hinarios';

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
    public function handle(HinarioService $hinarioService)
    {
        $hinarios = Hinario::get();

        foreach($hinarios as $hinario) {
            $hinarioService->preloadHinario($hinario->id);
        }
    }
}
