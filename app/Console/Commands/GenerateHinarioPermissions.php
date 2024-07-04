<?php

namespace App\Console\Commands;

use App\Constants\Constants;
use App\Models\Hinario;
use App\Services\PermissionService;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;


class GenerateHinarioPermissions extends Command
{
    private $permissionService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate-hinarios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate permissions for Hinarios';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;

        parent::__construct();
    }

    public function handle()
    {
        $hinarios = Hinario::all();
        foreach ($hinarios as $hinario) {
            $this->permissionService->createPermission('edit_hinario_' . $hinario->id, $hinario->getHinarioName(), Constants::PAGE_HINARIO);
        }

        $this->info('Hinario permissions generated successfully.');
        return Command::SUCCESS;
    }
}
