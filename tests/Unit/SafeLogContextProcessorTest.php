<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Logging\SafeLogContextProcessor;
use DateTimeImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;

final class SafeLogContextProcessorTest extends TestCase
{
    public function test_it_keeps_only_bounded_correlation_metadata_and_drops_sensitive_context(): void
    {
        $record = new LogRecord(
            new DateTimeImmutable('2026-11-19 00:00:00'),
            'sec06-test',
            Level::Warning,
            'Synthetic event {event_code}',
            [
                'event_code' => 'SEC06.CLEANUP',
                'correlation_id' => 'trace-123_ABC',
                'password' => 'synthetic-password',
                'authorization' => 'Bearer synthetic-token',
                'cookie' => 'synthetic-cookie',
                'session_id' => 'synthetic-session',
                'api_key' => 'synthetic-api-key',
                'request_body' => 'synthetic-request-body',
                'evidence_payload' => 'synthetic-evidence',
                'contact_email' => 'synthetic@example.invalid',
                'unbounded' => str_repeat('x', 65),
                'invalid_event_code' => 'not-used',
            ],
        );

        $processed = (new SafeLogContextProcessor())($record);

        self::assertSame([
            'event_code' => 'SEC06.CLEANUP',
            'correlation_id' => 'trace-123_ABC',
        ], $processed->context);

        $serializedContext = json_encode($processed->context, JSON_THROW_ON_ERROR);
        self::assertStringNotContainsString('synthetic-password', $serializedContext);
        self::assertStringNotContainsString('synthetic-token', $serializedContext);
        self::assertStringNotContainsString('synthetic-cookie', $serializedContext);
        self::assertStringNotContainsString('synthetic-session', $serializedContext);
        self::assertStringNotContainsString('synthetic-api-key', $serializedContext);
        self::assertStringNotContainsString('synthetic-request-body', $serializedContext);
        self::assertStringNotContainsString('synthetic-evidence', $serializedContext);
        self::assertStringNotContainsString('synthetic@example.invalid', $serializedContext);
    }
}
