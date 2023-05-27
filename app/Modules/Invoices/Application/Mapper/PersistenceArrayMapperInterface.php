<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mapper;

use App\Modules\Invoices\Domain\Entity\EntityInterface;

interface PersistenceArrayMapperInterface
{
    /**
     * @return array<string, mixed>
     */
    public static function fromEntityToPersistenceArray(EntityInterface $entity): array;
}
