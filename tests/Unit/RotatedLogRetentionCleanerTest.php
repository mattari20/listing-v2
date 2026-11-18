<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Logging\AgeBasedRotatingFileHandler;
use App\Logging\RotatedLogRetentionCleaner;
use DateTimeImmutable;
use DateTimeZone;
use Monolog\Level;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

final class RotatedLogRetentionCleanerTest extends TestCase
{
    private string $directory;

    protected function setUp(): void
    {
        parent::setUp();

        $base = tempnam(sys_get_temp_dir(), 'sec06-');

        self::assertNotFalse($base);
        unlink($base);
        mkdir($base);
        $this->directory = $base;
    }

    protected function tearDown(): void
    {
        if (is_dir($this->directory)) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->directory, \FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST,
            );

            foreach ($iterator as $entry) {
                $entry->isDir() && !$entry->isLink()
                    ? rmdir($entry->getPathname())
                    : unlink($entry->getPathname());
            }

            rmdir($this->directory);
        }

        parent::tearDown();
    }

    public function test_it_deletes_only_matching_daily_logs_strictly_older_than_thirty_days(): void
    {
        $this->touch('laravel-2026-10-19.log');
        $this->touch('laravel-2026-10-20.log');
        $this->touch('laravel-2026-10-21.log');
        $this->touch('laravel-2026-11-19.log');
        $this->touch('laravel-2026-10-01.log.bak');
        $this->touch('other-2026-10-01.log');

        mkdir($this->directory.'/nested');
        file_put_contents($this->directory.'/nested/laravel-2026-10-01.log', 'nested');

        $deleted = (new RotatedLogRetentionCleaner)->prune(
            $this->directory,
            'laravel',
            'log',
            new DateTimeImmutable('2026-11-19 00:00:00', new DateTimeZone('UTC')),
        );

        self::assertSame(['laravel-2026-10-19.log'], $deleted);
        self::assertFileDoesNotExist($this->directory.'/laravel-2026-10-19.log');
        self::assertFileExists($this->directory.'/laravel-2026-10-20.log');
        self::assertFileExists($this->directory.'/laravel-2026-10-21.log');
        self::assertFileExists($this->directory.'/laravel-2026-11-19.log');
        self::assertFileExists($this->directory.'/laravel-2026-10-01.log.bak');
        self::assertFileExists($this->directory.'/other-2026-10-01.log');
        self::assertFileExists($this->directory.'/nested/laravel-2026-10-01.log');
    }

    public function test_it_does_not_follow_or_delete_matching_symlinks(): void
    {
        $outside = $this->directory.'-outside';
        file_put_contents($outside, 'preserve');
        $link = $this->directory.'/laravel-2026-10-01.log';

        if (!@symlink($outside, $link)) {
            unlink($outside);
            self::markTestSkipped('Symlinks are not available in this test environment.');
        }

        try {
            $deleted = (new RotatedLogRetentionCleaner)->prune(
                $this->directory,
                'laravel',
                'log',
                new DateTimeImmutable('2026-11-19 00:00:00', new DateTimeZone('UTC')),
            );

            self::assertSame([], $deleted);
            self::assertTrue(is_link($link));
            self::assertFileExists($outside);
        } finally {
            unlink($outside);
        }
    }

    public function test_it_rejects_an_unavailable_directory_without_attempting_cleanup(): void
    {
        $this->expectException(RuntimeException::class);

        (new RotatedLogRetentionCleaner)->prune(
            $this->directory.'/missing',
            'laravel',
            'log',
            new DateTimeImmutable('2026-11-19 00:00:00', new DateTimeZone('UTC')),
        );
    }

    public function test_handler_uses_warning_level_and_performs_age_cleanup_on_rotation(): void
    {
        $this->touch('laravel-2026-10-01.log');

        $handler = new AgeBasedRotatingFileHandler(
            $this->directory.'/laravel.log',
            new RotatedLogRetentionCleaner,
            Level::Warning,
            new DateTimeZone('UTC'),
        );

        $logger = new Logger('sec06-test');
        $logger->pushHandler($handler);
        $logger->info('synthetic info event');
        $logger->warning('synthetic warning event');
        $handler->close();

        self::assertFileDoesNotExist($this->directory.'/laravel-2026-10-01.log');
        self::assertFileExists($this->directory.'/laravel-'.(new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d').'.log');
        $current = file_get_contents($this->directory.'/laravel-'.(new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d').'.log');
        self::assertIsString($current);
        self::assertStringContainsString('synthetic warning event', $current);
        self::assertStringNotContainsString('synthetic info event', $current);
    }

    private function touch(string $filename): void
    {
        file_put_contents($this->directory.'/'.$filename, 'synthetic');
    }
}
