<?php

declare(strict_types=1);

namespace App\Domain\Models;

use LogicException;

readonly class Money
{
    public function __construct(
        public int $price,
        public string $currency = 'usd',
    ) {
    }

    public function multiply(int $multiplier): Money
    {
        if ($multiplier <= 0) {
            throw new LogicException('Multiplier should be positive');
        }

        return new self($this->price * $multiplier, $this->currency);
    }

    public function add(Money $money): Money
    {
        return new self($this->price + $money->price, $this->currency);
    }
}
