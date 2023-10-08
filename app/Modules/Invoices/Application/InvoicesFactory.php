<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Application\Approver\InvoicesApprover;
use App\Modules\Invoices\Application\Reader\InvoicesReader;
use App\Modules\Invoices\Application\Repository\InvoicesRepositoryInterface;

class InvoicesFactory
{
    public function createInvoicesReader(): InvoicesReader
    {
        return new InvoicesReader(
            $this->getRepository(),
        );
    }


    public function createInvoicesApprover(): InvoicesApprover
    {
        return new InvoicesApprover(
            $this->getApprovalFacade(),
            $this->getRepository(),
        );
    }

    public function getRepository(): InvoicesRepositoryInterface
    {
        return app()->get(InvoicesRepositoryInterface::class);
    }

    public function getApprovalFacade(): ApprovalFacadeInterface
    {
        return app()->get(ApprovalFacadeInterface::class);
    }
}
