<?php

declare(strict_types=1);

/**
 * Copyright (C) Rafał Brauner
 */

namespace App\Tests\Other;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class SystemCheckTest extends TestCase
{
    public function testSystemIsWorking(): void
    {
        $this->expectNotToPerformAssertions();
    }
}
