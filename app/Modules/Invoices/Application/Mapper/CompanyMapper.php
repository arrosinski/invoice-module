<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mapper;

use App\Modules\Invoices\Api\Dto\CompanyDto;
use App\Modules\Invoices\Api\Dto\DtoInterface;
use App\Modules\Invoices\Domain\Entity\Company;
use App\Modules\Invoices\Domain\Entity\EntityInterface;
use Ramsey\Uuid\Uuid;

final class CompanyMapper implements EntityMapperInterface, DtoMapperInterface, ArrayMapperInterface
{
    /**
     * @throws \Exception
     */
    public static function fromRawToEntity(object $raw): Company
    {
        return new Company(
            Uuid::fromString($raw->id),
            $raw->name,
            $raw->street,
            $raw->city,
            $raw->zip,
            $raw->phone,
            $raw->email,
            isset($raw->createdAt) ? new \DateTimeImmutable($raw->createdAt) : null,
            isset($raw->updatedAt) ? new \DateTimeImmutable($raw->updatedAt) : null,
        );
    }

    /**
     * @param Company $entity
     */
    public static function fromEntityToDto(EntityInterface $entity): CompanyDto
    {
        return new CompanyDto(
            $entity->getId(),
            $entity->getName(),
            $entity->getStreet(),
            $entity->getCity(),
            $entity->getZip(),
            $entity->getPhone(),
            $entity->getEmail(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),
        );
    }

    /**
     * @inheritDoc
     *
     * @param CompanyDto $dto
     */
    public static function fromDtoToArray(
        DtoInterface $dto,
        bool $format = true,
        bool $timestamps = false
    ): array {
        $return = [
            'name' => $dto->name,
            'street' => $dto->street,
            'city' => $dto->city,
            'zip' => $dto->zip,
            'phone' => $dto->phone,
        ];

        if ($timestamps) {
            $return = [
                ...$return,
                'createdAt' => $dto->createdAt?->format('c'),
                'updatedAt' => $dto->updatedAt?->format('c'),
            ];
        }

        return $return;
    }
}
