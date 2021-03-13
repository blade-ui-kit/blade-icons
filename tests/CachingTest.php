<?php

declare(strict_types=1);

namespace Tests;

class CachingTest extends TestCase
{
    /** @test */
    public function it_can_create_a_cache_file()
    {
        $this->artisan('icons:cache')
            ->expectsOutput('Blade icons manifest file generated successfully!')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_can_clear_the_cache()
    {
        $this->artisan('icons:clear')
            ->expectsOutput('Blade icons manifest file cleared!')
            ->assertExitCode(0);
    }
}
