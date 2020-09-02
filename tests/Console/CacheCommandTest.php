<?php

declare(strict_types=1);

namespace Tests\Console;

use Tests\TestCase;

class CacheCommandTest extends TestCase
{
    /** @test */
    public function it_can_create_a_cache_file()
    {
        $this->artisan('icons:cache')
            ->expectsOutput('Blade icons manifest file generated successfully!')
            ->assertExitCode(0);
    }
}
