<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use Ramsey\Uuid\UuidInterface;

final class Company implements EntityInterface
{
    public function __construct(
        private readonly UuidInterface $id,
        private string $name,
        private string $street,
        private string $city,
        private string $zip,
        private string $phone,
        private string $email,
        private readonly ?\DateTimeInterface $createdAt,
        private readonly ?\DateTimeInterface $updatedAt,
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
