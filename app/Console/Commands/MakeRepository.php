<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $name = str_replace('Repository', '', $name);
        $name = str_replace('Interface', '', $name);

        $this->call('create:repository-interface', [
            'name' => "{$name}Interface",
        ]);

        $this->call('create:repository', [
            'name' => "{$name}Repository",
        ]);

        $this->call('create:service-interface', [
            'name' => "{$name}Interface",
        ]);

        $this->call('create:service', [
            'name' => "{$name}Service",
        ]);

        $this->call('create:facade', [
            'name' => "{$name}Facade"
        ]);

        $this->info("
            All Classes are successfully created, now please add this changes - \n
            1) In RepositoryServiceProvider add - {$name}Interface::class => {$name}Repository::class \n
            2) In config\app.php in 'aliases' array add \"{$name}Facade\" => App\Facades\{$name}Facade::class \n
            3) In FacadeServiceProvider (in register method) add -
                \$this->app->bind('{$name}Service', function (Application \$app) {
                    return app()->make({$name}Service::class);
                });
            ");
    }
}
