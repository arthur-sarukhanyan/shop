<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Concerns\HasParameters;
use Symfony\Component\Console\Input\InputOption;

class MakeRepository extends Command
{
    /**
     * Possible arguments
     *
     * @var array|string[]
     */
    private array $possibleOptions = [
        '--s',       //with service
        '--sf',      //with service and facade
        '--all',     //with service and facade
    ];

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

    public function __construct()
    {
        $this->updateSignature();

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $name = str_replace('Repository', '', $name);
        $name = str_replace('Interface', '', $name);

        if (!$this->modelExists($name)) {
            $this->info("{$name} model could not be found. Please create model before running this command");
            return;
        }

        if ($this->repositoryExists($name)) {
            $this->info("{$name}Repository already exists");
            return;
        }

        $message = "All Classes are successfully created, now please add this changes - \n
                1) In RepositoryServiceProvider add - {$name}Interface::class => {$name}Repository::class \n";

        $this->call('create:repository-interface', [
            'name' => "{$name}Interface",
        ]);

        $this->call('create:repository', [
            'name' => "{$name}Repository",
        ]);

        if ($this->shouldCreate('service')) {
            $this->call('create:service-interface', [
                'name' => "{$name}Interface",
            ]);

            $this->call('create:service', [
                'name' => "{$name}Service",
            ]);
        }

        if ($this->shouldCreate('facade')) {
            $this->call('create:facade', [
                'name' => "{$name}Facade"
            ]);

            $message .= "
                2) In config\app.php in 'aliases' array add \"{$name}Facade\" => App\Facades\\{$name}Facade::class \n
                3) In FacadeServiceProvider (in register method) add -
                    \$this->app->bind('{$name}Service', function (Application \$app) {
                        return app()->make({$name}Service::class);
                    });
                ";
        }

        $this->info($message);
    }

    /**
     * @param $name
     * @return bool
     */
    private function modelExists($name): bool
    {
        $modelPath = 'App\Models\\';
        $name = ucfirst(strtolower($name));
        return class_exists($modelPath . $name);
    }

    /**
     * @param $name
     * @return bool
     */
    private function repositoryExists($name): bool
    {
        $repoPath = 'App\Repositories\\';
        $name = ucfirst(strtolower($name));
        return class_exists($repoPath . $name . 'Repository');
    }

    private function updateSignature(): void
    {
        foreach ($this->possibleOptions as $option) {
            $this->signature .= ' {' . $option . '}';
        }
    }

    /**
     * @return array[]
     */
    protected function getOptions(): array
    {
        return [
            ['service', 's', InputOption::VALUE_OPTIONAL, 'Create service class with repository'],
            ['serviceFacade', 'sf', InputOption::VALUE_OPTIONAL, 'Create service class with repository and facade'],
            ['serviceFacade', 'all', InputOption::VALUE_OPTIONAL, 'Create service class with repository and facade'],
        ];
    }

    /**
     * @param string $type
     * @return bool
     */
    private function shouldCreate(string $type): bool
    {
        $res = false;

        switch ($type)
        {
            case 'service':
                foreach ($this->possibleOptions as $option) {
                    if ($this->option(str_replace('--', '', $option))) {
                        $res = true;
                        break;
                    }
                }
                break;
            case 'facade':
                if ($this->option('sf') || $this->option('all')) {
                    $res = true;
                }
                break;
        }

        return $res;
    }
}
