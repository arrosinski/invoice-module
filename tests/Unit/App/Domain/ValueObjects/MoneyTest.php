<?php

namespace Tests\Unit\App\Domain\ValueObjects;

use App\Domain\ValueObjects\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function test_add(): void
    {
        $money = new Money(10);
        $sum = $money->add(new Money(2));

        $this->assertEquals(12, $sum->amount);
    }

    public function test_multiply(): void
    {
        $money = new Money(10);
        $multiplication = $money->multiply(2);

        $this->assertEquals(20, $multiplication->amount);
    }
}
