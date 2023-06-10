<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'create:repository-interface')]
class CreateRepositoryInterface extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:repository-interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating repository interface';

    /**
     * Creating class type
     *
     * @var string
     */
    protected string $classType = 'Interface';

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
        $relativePath = '/stubs/repository.interface.stub';
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
        return $rootNamespace.'\Repositories\Interfaces';
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
