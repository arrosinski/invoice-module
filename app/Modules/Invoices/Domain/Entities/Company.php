<?php

namespace App\Modules\Invoices\Domain\Entities;

readonly class Company
{
    public function __construct(
        public string $id,
        public string $name,
        public string $street,
        public string $city,
        public string $zip,
        public string $phone,
        public string $email,
        public string $createdAt,
        public string $updatedAt
    ) {
    }

    public static function create(
        string $id,
        string $name,
        string $street,
        string $city,
        string $zip,
        string $phone,
        string $email,
        string $createdAt,
        string $updatedAt
    ): self {
        return new self(
            $id,
            $name,
            $street,
            $city,
            $zip,
            $phone,
            $email,
            $createdAt,
            $updatedAt
        );
    }

    public static function blank(): self
    {
        return new self(
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        );
    }
}
