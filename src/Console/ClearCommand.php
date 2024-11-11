<?php

declare(strict_types=1);

namespace BladeUI\Icons\Console;

use BladeUI\Icons\IconsManifest;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'icons:clear')]
final class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icons:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the blade icons manifest file';

    
    public function handle(IconsManifest $manifest): int
    {
        $manifest->delete();
        
        $this->components->info('Cached blade icons cleared successfully.');

        return 0;
    }
}
