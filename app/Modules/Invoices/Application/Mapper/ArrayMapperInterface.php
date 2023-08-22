<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mapper;

use App\Modules\Invoices\Api\Dto\DtoInterface;

interface ArrayMapperInterface
{
    /**
     * @return array<string, mixed>
     */
    public static function fromDtoToArray(
        DtoInterface $dto,
        bool $format = true,
        bool $timestamps = false
    ): array;
}
