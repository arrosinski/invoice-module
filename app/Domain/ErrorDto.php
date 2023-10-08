<?php

declare(strict_types=1);

namespace App\Domain;

class ErrorDto
{
    public function __construct(
        public ?string $message = null,
    ) {
    }
}
