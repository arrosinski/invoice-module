<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repository;

use App\Modules\Invoices\Domain\Entity\Company;
use App\Modules\Invoices\Domain\Entity\Invoice;
use EduardoMarques\TypedCollections\TypedCollectionInterface;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepositoryInterface
{
    public function findById(UuidInterface $id): ?Invoice;

    public function findProductsById(UuidInterface $id): TypedCollectionInterface;

    public function findCompanyById(UuidInterface $id): ?Company;

    public function update(Invoice $invoice): void;
}
