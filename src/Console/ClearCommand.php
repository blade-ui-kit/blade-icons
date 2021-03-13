<?php

declare(strict_types=1);

namespace BladeUI\Icons\Console;

use BladeUI\Icons\IconsManifest;
use Illuminate\Console\Command;

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

        $this->info('Blade icons manifest file cleared!');

        return 0;
    }
}
