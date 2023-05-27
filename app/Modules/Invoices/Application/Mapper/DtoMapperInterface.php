<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mapper;

use App\Modules\Invoices\Api\Dto\DtoInterface;
use App\Modules\Invoices\Domain\Entity\EntityInterface;

interface DtoMapperInterface
{
    public static function fromEntityToDto(EntityInterface $entity): DtoInterface;
}
