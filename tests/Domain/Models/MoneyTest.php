<?php

declare(strict_types=1);

namespace Tests\Domain\Models;

use App\Domain\Models\Money;
use LogicException;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testMultiply(): void
    {
        $money = new Money(100);

        $this->assertEquals(new Money(300), $money->multiply(3));
    }

    public function testInvalidMultiply(): void
    {
        $this->expectException(LogicException::class);

        $money = new Money(100);
        $money->multiply(0);
    }

    public function testSum(): void
    {
        $money = new Money(100);

        $this->assertEquals(new Money(300), $money->add(new Money(200)));
    }
}
