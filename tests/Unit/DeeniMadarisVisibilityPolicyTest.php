<?php

namespace Tests\Unit;

use App\Policies\DeeniMadarisVisibilityPolicy;
use Tests\TestCase;

final class DeeniMadarisVisibilityPolicyTest extends TestCase
{
    public function test_deeni_madaris_visibility_is_off_by_default(): void
    {
        config()->set('directory.deeni_madaris_public', false);

        $this->assertFalse((new DeeniMadarisVisibilityPolicy)->isPubliclyVisible());
    }

    public function test_unset_visibility_configuration_fails_closed(): void
    {
        config()->offsetUnset('directory.deeni_madaris_public');

        $this->assertFalse((new DeeniMadarisVisibilityPolicy())->isPubliclyVisible());
    }
}
