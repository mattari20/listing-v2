<?php

declare(strict_types=1);

namespace App\Logging;

use Monolog\LogRecord;

final class SafeLogContextProcessor
{
    /**
     * Keep only bounded, non-user-controlled correlation metadata.
     *
     * Application log messages must still be authored without secrets or
     * personal data; this processor minimizes structured context, not messages.
     */
    public function __invoke(LogRecord $record): LogRecord
    {
        $context = [];

        foreach (['event_code', 'correlation_id'] as $key) {
            $value = $record->context[$key] ?? null;

            if (is_string($value) && preg_match('/^[A-Za-z0-9_.:-]{1,64}$/D', $value) === 1) {
                $context[$key] = $value;
            }
        }

        return $record->with(context: $context);
    }
}
