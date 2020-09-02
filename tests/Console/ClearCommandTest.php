<?php

declare(strict_types=1);

namespace Tests\Console;

use Tests\TestCase;

class ClearCommandTest extends TestCase
{
    /** @test */
    public function it_can_clear_the_cache()
    {
        $this->artisan('icons:clear')
            ->expectsOutput('Blade icons manifest file cleared!')
            ->assertExitCode(0);
    }
}
