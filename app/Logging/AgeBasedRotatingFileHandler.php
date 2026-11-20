<?php

declare(strict_types=1);

namespace App\Logging;

use DateTimeImmutable;
use DateTimeZone;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Level;

final class AgeBasedRotatingFileHandler extends RotatingFileHandler
{
    private RotatedLogRetentionCleaner $cleaner;

    private DateTimeZone $retentionTimezone;

    public function __construct(
        string $filename,
        ?RotatedLogRetentionCleaner $cleaner = null,
        int|string|Level $level = Level::Warning,
        ?DateTimeZone $timezone = null,
    ) {
        $this->cleaner = $cleaner ?? new RotatedLogRetentionCleaner();
        $this->retentionTimezone = $timezone ?? new DateTimeZone(date_default_timezone_get());

        // Disable Monolog's count-based garbage collection. The approved policy
        // is a calendar-age rule, enforced by RotatedLogRetentionCleaner.
        parent::__construct(
            $filename,
            0,
            $level,
            true,
            null,
            false,
            self::FILE_PER_DAY,
            '{filename}-{date}',
            $this->retentionTimezone,
        );
    }

    protected function rotate(): void
    {
        parent::rotate();

        $fileInfo = pathinfo($this->filename);

        $this->cleaner->prune(
            dirname($this->filename),
            $fileInfo['filename'],
            $fileInfo['extension'] ?? '',
            new DateTimeImmutable('now', $this->retentionTimezone),
            30,
        );
    }
}
