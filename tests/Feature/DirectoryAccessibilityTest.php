<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class DirectoryAccessibilityTest extends TestCase
{
    #[DataProvider('directoryTemplates')]
    public function test_directory_templates_retain_skip_navigation_and_visible_focus(string $path): void
    {
        $source = file_get_contents(resource_path($path));

        self::assertIsString($source);
        self::assertStringContainsString('lang="en"', $source);
        self::assertStringContainsString('class="skip-link" href="#main-content"', $source);
        self::assertStringContainsString('id="main-content" tabindex="-1"', $source);
        self::assertStringContainsString(':focus-visible', $source);
        self::assertStringContainsString('outline: 3px solid #005fcc', $source);
    }

    public static function directoryTemplates(): array
    {
        return [
            'directory search page' => ['views/directory/index.blade.php'],
            'directory profile page' => ['views/directory/show.blade.php'],
        ];
    }

    public function test_directory_text_and_control_colors_meet_wcag_aa_contrast_thresholds(): void
    {
        $index = file_get_contents(resource_path('views/directory/index.blade.php'));
        $profile = file_get_contents(resource_path('views/directory/show.blade.php'));

        self::assertIsString($index);
        self::assertIsString($profile);

        // Assert the measured palette remains the palette actually declared in both templates.
        self::assertStringContainsString('color: #172033; background: #f7f8fa;', $index);
        self::assertStringContainsString('color: #172033; background: #f7f8fa;', $profile);
        self::assertStringContainsString('color: #4b5563; font-size: .94rem;', $index);
        self::assertStringContainsString('color: #4b5563; font-size: .94rem;', $profile);
        self::assertStringContainsString('a { color: #174ea6; }', $index);
        self::assertStringContainsString('a { color: #174ea6; }', $profile);
        self::assertStringContainsString('background: #172033; color: #fff; border-color: #172033;', $index);
        self::assertStringContainsString('outline: 3px solid #005fcc', $index);
        self::assertStringContainsString('outline: 3px solid #005fcc', $profile);
        self::assertStringContainsString('border: 1px solid #8b95a5', $index);

        $textPairs = [
            ['#172033', '#f7f8fa'],
            ['#4b5563', '#ffffff'],
            ['#174ea6', '#ffffff'],
            ['#ffffff', '#172033'],
            ['#005fcc', '#ffffff'],
            ['#005fcc', '#f7f8fa'],
        ];

        foreach ($textPairs as [$foreground, $background]) {
            self::assertGreaterThanOrEqual(
                4.5,
                $this->contrastRatio($foreground, $background),
                sprintf('Insufficient text/focus contrast for %s on %s.', $foreground, $background)
            );
        }

        // Form control boundaries are non-text UI components and require 3:1.
        self::assertGreaterThanOrEqual(3.0, $this->contrastRatio('#8b95a5', '#ffffff'));
    }

    private function contrastRatio(string $foreground, string $background): float
    {
        $foregroundLuminance = $this->relativeLuminance($foreground);
        $backgroundLuminance = $this->relativeLuminance($background);

        return (max($foregroundLuminance, $backgroundLuminance) + 0.05)
            / (min($foregroundLuminance, $backgroundLuminance) + 0.05);
    }

    private function relativeLuminance(string $color): float
    {
        $channels = [
            hexdec(substr($color, 1, 2)) / 255,
            hexdec(substr($color, 3, 2)) / 255,
            hexdec(substr($color, 5, 2)) / 255,
        ];

        $linear = array_map(
            static fn (float $channel): float => $channel <= 0.04045
                ? $channel / 12.92
                : (($channel + 0.055) / 1.055) ** 2.4,
            $channels
        );

        return (0.2126 * $linear[0]) + (0.7152 * $linear[1]) + (0.0722 * $linear[2]);
    }
}
