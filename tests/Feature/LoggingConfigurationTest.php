<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Logging\AgeBasedRotatingFileHandler;
use App\Logging\SafeLogContextProcessor;
use Illuminate\Support\Facades\Log;
use Monolog\Logger as MonologLogger;
use Monolog\Processor\PsrLogMessageProcessor;
use Tests\TestCase;

final class LoggingConfigurationTest extends TestCase
{
    public function test_default_logging_channel_is_bounded_daily_local_file_logging(): void
    {
        $stack = config('logging.channels.stack');
        $daily = config('logging.channels.daily');

        self::assertSame(['daily'], $stack['channels']);
        self::assertSame('monolog', $daily['driver']);
        self::assertSame(AgeBasedRotatingFileHandler::class, $daily['handler']);
        self::assertSame('warning', $daily['level']);
        self::assertSame([
            SafeLogContextProcessor::class,
            PsrLogMessageProcessor::class,
        ], $daily['processors']);
        self::assertSame(storage_path('logs/laravel.log'), $daily['handler_with']['filename']);

        // PHPUnit explicitly sets LOG_CHANNEL=stack; the default stack resolves only to daily.
        self::assertSame('stack', config('logging.default'));

        $resolvedLogger = Log::channel('daily')->getLogger();
        self::assertInstanceOf(MonologLogger::class, $resolvedLogger);
        self::assertInstanceOf(AgeBasedRotatingFileHandler::class, $resolvedLogger->getHandlers()[0]);
    }
}
