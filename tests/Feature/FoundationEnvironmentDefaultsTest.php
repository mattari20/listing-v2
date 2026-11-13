<?php

namespace Tests\Feature;

use Tests\TestCase;

final class FoundationEnvironmentDefaultsTest extends TestCase
{
    public function test_runtime_defaults_are_safe_for_local_and_ci_foundation_work(): void
    {
        $this->assertSame('testing', config('app.env'));
        $this->assertFalse(config('app.debug'));

        $this->assertSame('array', config('cache.default'));
        $this->assertSame('array', config('session.driver'));
        $this->assertSame('sync', config('queue.default'));
        $this->assertSame('local', config('filesystems.default'));
        $this->assertFileDoesNotExist(base_path('config/database.php'));
        $this->assertSame('array', config('mail.default'));
    }

    public function test_logging_defaults_are_local_and_non_verbose(): void
    {
        $this->assertSame('stack', config('logging.default'));
        $this->assertSame(['single'], config('logging.channels.stack.channels'));
        $this->assertSame('warning', config('logging.channels.single.level'));
        $this->assertSame('null', config('logging.deprecations.channel'));
        $this->assertFalse(config('logging.deprecations.trace'));
    }
}
