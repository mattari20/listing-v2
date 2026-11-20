<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Logging\SafeLogContextProcessor;
use DateTimeImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;

final class SafeLogPayloadBoundaryTest extends TestCase
{
    public function test_it_drops_nested_payloads_and_unapproved_context_keys(): void
    {
        $record = new LogRecord(
            new DateTimeImmutable('2026-11-20 00:00:00'),
            'lps24-synthetic',
            Level::Warning,
            'Synthetic governance event',
            [
                'event_code' => 'GOVERNANCE.PROPOSAL',
                'correlation_id' => 'lps24-trace-001',
                'claim_value' => ['synthetic_private_marker' => 'SYNTHETIC-CLAIM-VALUE-DO-NOT-LOG'],
                'snapshot_payload' => ['nested' => ['marker' => 'SYNTHETIC-SNAPSHOT-PAYLOAD']],
                'outbox_payload' => ['password' => 'SYNTHETIC-OUTBOX-SECRET'],
                'last_error' => 'SYNTHETIC-ERROR-DETAIL',
                'rationale' => 'SYNTHETIC-PRIVATE-RATIONALE',
                'audit_metadata' => ['contact' => 'synthetic@example.invalid'],
                'request' => (object) ['body' => 'SYNTHETIC-REQUEST-BODY'],
            ],
        );

        $processed = (new SafeLogContextProcessor)($record);

        self::assertSame([
            'event_code' => 'GOVERNANCE.PROPOSAL',
            'correlation_id' => 'lps24-trace-001',
        ], $processed->context);

        $serialized = json_encode($processed->context, JSON_THROW_ON_ERROR);

        foreach ([
            'SYNTHETIC-CLAIM-VALUE-DO-NOT-LOG',
            'SYNTHETIC-SNAPSHOT-PAYLOAD',
            'SYNTHETIC-OUTBOX-SECRET',
            'SYNTHETIC-ERROR-DETAIL',
            'SYNTHETIC-PRIVATE-RATIONALE',
            'synthetic@example.invalid',
            'SYNTHETIC-REQUEST-BODY',
        ] as $marker) {
            self::assertStringNotContainsString($marker, $serialized);
        }
    }

    public function test_it_rejects_invalid_or_unbounded_allowlisted_correlation_values(): void
    {
        $record = new LogRecord(
            new DateTimeImmutable('2026-11-20 00:00:00'),
            'lps24-synthetic',
            Level::Warning,
            'Synthetic event',
            [
                'event_code' => str_repeat('E', 65),
                'correlation_id' => 'trace value with spaces',
                'extra_event' => 'NOT-ALLOWLISTED',
            ],
        );

        $processed = (new SafeLogContextProcessor)($record);

        self::assertSame([], $processed->context);
    }

    public function test_it_does_not_claim_to_sanitize_log_message_text(): void
    {
        $message = 'Synthetic marker in authored message: SYNTHETIC-MESSAGE-MARKER';
        $record = new LogRecord(
            new DateTimeImmutable('2026-11-20 00:00:00'),
            'lps24-synthetic',
            Level::Warning,
            $message,
            ['event_code' => 'GOVERNANCE.MESSAGE_BOUNDARY'],
        );

        $processed = (new SafeLogContextProcessor)($record);

        self::assertSame($message, $processed->message);
        self::assertSame(['event_code' => 'GOVERNANCE.MESSAGE_BOUNDARY'], $processed->context);
    }
}
