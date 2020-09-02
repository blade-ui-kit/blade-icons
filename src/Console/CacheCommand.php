<?php

declare(strict_types=1);

namespace BladeUI\Icons\Console;

use BladeUI\Icons\IconsManifest;
use Illuminate\Console\Command;

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

    /** @var IconsManifest */
    private $manifest;

    public function __construct(IconsManifest $manifest)
    {
        parent::__construct();

        $this->manifest = $manifest;
    }

    public function handle(): int
    {
        $this->manifest->build();

        $this->info('Blade icons manifest file generated successfully!');

        return 0;
    }
}
