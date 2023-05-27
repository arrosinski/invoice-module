<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mapper;

use App\Modules\Invoices\Domain\Entity\EntityInterface;

interface EntityMapperInterface
{
    public static function fromRawToEntity(object $raw): EntityInterface;
}
