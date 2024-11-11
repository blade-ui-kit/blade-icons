<?php

declare(strict_types=1);

namespace BladeUI\Icons\Console;

use BladeUI\Icons\Factory;
use BladeUI\Icons\IconsManifest;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'icons:cache')]
final class CacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icons:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discover icon sets and generate a manifest file';

    public function handle(Factory $factory, IconsManifest $manifest): int
    {
        $manifest->write($factory->all());

        $this->components->info('Blade icons cached successfully.');

        return 0;
    }
}
