<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'create:facade')]
class CreateFacade extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:facade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating Facade class';

    /**
     * An associative array for stub variables replacing
     * key is property name in replace method, and value is
     * variable in stub
     *
     * @var array|string[]
     */
    protected array $stubVars = [
        'service' => '{{service}}',
    ];

    /**
     * Creating class type
     *
     * @var string
     */
    protected string $classType = 'Facade';

    /**
     * Command type
     *
     * @var string
     */
    protected $type = 'Console command';

    /**
     * Get stub path
     *
     * @return string
     */
    protected function getStub(): string
    {
        $relativePath = '/stubs/facade.stub';
        return __DIR__ . $relativePath;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Facades';
    }

    /**
     * Get creating class name from argument and
     * add class type to it
     *
     * @return string
     */
    protected function getNameInput(): string
    {
        $name = trim($this->argument('name'));

        if (!str_contains($name, $this->classType)) {
            $name .= $this->classType;
        }

        return $name;
    }

    /**
     * Run variables replacing methods for stub
     *
     * @param $name
     * @return array|string
     * @throws FileNotFoundException
     */
    protected function buildClass($name): array|string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceVars($stub, $name)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace variables in stub
     *
     * @param $stub
     * @param $name
     * @return $this
     */
    protected function replaceVars(&$stub, $name): static
    {
        $model = str_replace('App\Facades\\', '', $name);
        $model = str_replace($this->classType, '', $model);
        $service = $model . 'Service';

        foreach ($this->stubVars as $key => $value) {
            $stub = str_replace(
                $value,
                $$key,
                $stub
            );
        }

        return $this;
    }
}
