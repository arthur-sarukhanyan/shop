<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'create:service-interface')]
class CreateServiceInterface extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:service-interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating service interface';

    /**
     * Creating class type
     *
     * @var string
     */
    protected string $classType = 'Interface';

    /**
     * Creating class type
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
        $relativePath = '/stubs/service.interface.stub';
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
        return $rootNamespace.'\Services\Interfaces';
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
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }

}
