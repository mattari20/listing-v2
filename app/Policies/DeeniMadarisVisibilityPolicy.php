<?php

namespace App\Policies;

final class DeeniMadarisVisibilityPolicy
{
    public function isPubliclyVisible(): bool
    {
        return (bool) config('directory.deeni_madaris_public', false);
    }
}
