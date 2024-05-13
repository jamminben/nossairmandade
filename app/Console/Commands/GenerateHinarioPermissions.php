<?php

namespace App\Console\Commands;

use App\Constants\Constants;
use App\Models\Hinario;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;


class GenerateHinarioPermissions extends Command
{
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
    public function handle()
    {
        $hinarios = Hinario::all();
        foreach ($hinarios as $hinario) {
            $this->createPermission('add', $hinario->id,$hinario->getHinarioName());
            $this->createPermission('edit', $hinario->id,$hinario->getHinarioName());
            $this->createPermission('delete', $hinario->id,$hinario->getHinarioName());
        }

        $this->info('Hinario permissions generated successfully.');
        return Command::SUCCESS;
    }

    protected function createPermission($action, $hinarioId,$group)
    {
        $permissionName = "{$action}_hinario_{$hinarioId}";
        // Check if permission already exists
        if (!Permission::where('name', $permissionName)->exists()) {
            Permission::create([
                'name' => $permissionName,
                'pages' => Constants::PAGE_HINARIO,
                'group' => $group,
            ]);
            $this->info("Permission created: $permissionName");
        } else {
            $this->info("Permission already exists: $permissionName");
        }
    }
}
