<?php

declare(strict_types=1);

namespace App\\Logging;

use DateTimeImmutable;
use DirectoryIterator;
use InvalidArgumentException;
use RuntimeException;

final class RotatedLogRetentionCleaner
{
    /**
     * Delete only daily rotated files matching the configured Laravel log basename.
     *
     * The date in the filename is the rotation date. Files exactly 30 days old
     * are retained; only files strictly older than the cutoff are removed.
     *
     * @return list<string> Deleted basenames, useful for deterministic verification.
     */
    public function prune(
        string $directory,
        string $filenamePrefix,
        string $extension,
        DateTimeImmutable $now,
        int $retentionDays = 30,
    ): array {
        if ($retentionDays < 1) {
            throw new InvalidArgumentException('Log retention must be at least one day.');
        }

        if ($filenamePrefix === '' || str_contains($filenamePrefix, '/') || str_contains($filenamePrefix, '\\\\')) {
            throw new InvalidArgumentException('The log filename prefix must be a basename.');
        }

        $extension = ltrim($extension, '.');

        if ($extension === '' || preg_match('/^[A-Za-z0-9]+$/D', $extension) !== 1) {
            throw new InvalidArgumentException('The log filename extension is invalid.');
        }

        $realDirectory = realpath($directory);

        if ($realDirectory === false || !is_dir($realDirectory) || is_link($directory)) {
            throw new RuntimeException('SEC-06 log retention could not access its configured directory.');
        }

        $pattern = '/^'.preg_quote($filenamePrefix, '/').'-(\\d{4}-\\d{2}-\\d{2})\\.'.preg_quote($extension, '/').'$/D';
        $cutoff = $now->modify('-'.$retentionDays.' days');
        $deleted = [];

        try {
            $entries = new DirectoryIterator($realDirectory);
        } catch (\\UnexpectedValueException) {
            throw new RuntimeException('SEC-06 log retention could not read its configured directory.');
        }

        foreach ($entries as $entry) {
            if ($entry->isDot() || $entry->isLink() || !$entry->isFile()) {
                continue;
            }

            $basename = $entry->getFilename();

            if (preg_match($pattern, $basename, $matches) !== 1) {
                continue;
            }

            $rotatedAt = DateTimeImmutable::createFromFormat(
                '!Y-m-d',
                $matches[1],
                $now->getTimezone(),
            );

            if ($rotatedAt === false || $rotatedAt->format('Y-m-d') !== $matches[1] || $rotatedAt >= $cutoff) {
                continue;
            }

            $realFile = realpath($entry->getPathname());

            if ($realFile === false || dirname($realFile) !== $realDirectory || is_link($entry->getPathname())) {
                continue;
            }

            if (!is_writable($realFile) || !unlink($realFile)) {
                throw new RuntimeException('SEC-06 log retention could not remove an expired rotated log file.');
            }

            $deleted[] = $basename;
        }

        return $deleted;
    }
}
