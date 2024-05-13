<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Enums\CurrencyEnum;

final readonly class Money
{
    public function __construct(
        public int $amount,
        public CurrencyEnum $currency = CurrencyEnum::USD
    ) {
    }

    public function add(self $money): self
    {
        if ($money->currency !== $this->currency) {
            throw new \DomainException('Incompatible currencies');
        }

        return new self($money->amount + $this->amount, $this->currency);
    }

    public function multiply(int $multiplier): self
    {
        return new self($this->amount * $multiplier, $this->currency);
    }

    public function __toString(): string
    {
        return sprintf("%d %s", $this->amount, strtoupper($this->currency->value));
    }
}
