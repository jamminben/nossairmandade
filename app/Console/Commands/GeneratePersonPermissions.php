<?php

namespace App\Console\Commands;

use App\Constants\Constants;
use App\Models\Hinario;
use App\Models\Person;
use App\Services\PermissionService;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;


class GeneratePersonPermissions extends Command
{
    private $permissionService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate-persons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate permissions for Persons';

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
        $persons = Person::all();
        foreach ($persons as $person) {
            $this->permissionService->createPermission('edit_person_' . $person->id, $person->display_name, Constants::PAGE_PERSON);
        }

        $this->info('Person permissions generated successfully.');
        return Command::SUCCESS;
    }
}
