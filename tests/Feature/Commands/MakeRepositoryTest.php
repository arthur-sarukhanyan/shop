<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class MakeRepositoryTest extends TestCase
{
    private string $testModel = 'Test';
    private string $realModel = 'User';
    private string $repositoryPath = 'Repositories\\';
    private string $repositoryInterfacePath = 'Repositories\Interfaces\\';
    private string $servicePath = 'Services\\';
    private string $serviceInterfacePath = 'Services\Interfaces\\';
    private string $facadePath = 'Facades\\';

    /**
     * A basic feature test example.
     */
    public function testCommandByDefault(): void
    {
        $this->artisan('make:repository ' . $this->testModel)
            ->assertSuccessful();

        $this->assertFileExists(app_path($this->repositoryPath . $this->testModel . 'Repository.php'));
        $this->assertFileExists(app_path($this->repositoryInterfacePath . $this->testModel . 'Interface.php'));
    }

    public function testCommandWithService(): void
    {
        $this->artisan('make:repository ' . $this->testModel . ' --s')
            ->assertSuccessful();

        $this->assertFileExists(app_path($this->repositoryPath . $this->testModel . 'Repository.php'));
        $this->assertFileExists(app_path($this->repositoryInterfacePath . $this->testModel . 'Interface.php'));
        $this->assertFileExists(app_path($this->servicePath . $this->testModel . 'Service.php'));
        $this->assertFileExists(app_path($this->serviceInterfacePath . $this->testModel . 'Interface.php'));
    }

    public function testCommandWithFacade(): void
    {
        $this->artisan('make:repository ' . $this->testModel . ' --sf')
            ->assertSuccessful();

        $this->assertFileExists(app_path($this->repositoryPath . $this->testModel . 'Repository.php'));
        $this->assertFileExists(app_path($this->repositoryInterfacePath . $this->testModel . 'Interface.php'));
        $this->assertFileExists(app_path($this->servicePath . $this->testModel . 'Service.php'));
        $this->assertFileExists(app_path($this->serviceInterfacePath . $this->testModel . 'Interface.php'));
        $this->assertFileExists(app_path($this->facadePath . $this->testModel . 'Facade.php'));
    }

    public function testCommandWithAll(): void
    {
        $this->artisan('make:repository ' . $this->testModel . ' --all')
            ->assertSuccessful();

        $this->assertFileExists(app_path($this->repositoryPath . $this->testModel . 'Repository.php'));
        $this->assertFileExists(app_path($this->repositoryInterfacePath . $this->testModel . 'Interface.php'));
        $this->assertFileExists(app_path($this->servicePath . $this->testModel . 'Service.php'));
        $this->assertFileExists(app_path($this->serviceInterfacePath . $this->testModel . 'Interface.php'));
        $this->assertFileExists(app_path($this->facadePath . $this->testModel . 'Facade.php'));
    }

    public function testCommandWithExistingRepository(): void
    {
        $this->artisan('make:repository ' . $this->realModel)
            ->assertSuccessful();
    }

    protected function cleanUp(): void
    {
        $files = [
            $this->repositoryPath . $this->testModel . 'Repository.php',
            $this->repositoryInterfacePath . $this->testModel . 'Interface.php',
            $this->servicePath . $this->testModel . 'Service.php',
            $this->serviceInterfacePath . $this->testModel . 'Interface.php',
            $this->facadePath . $this->testModel . 'Facade.php',
        ];

        foreach ($files as $file) {
            $path = app_path($file);
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    public function __destruct()
    {
        $this->cleanUp();
    }
}
