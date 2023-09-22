<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application;

use App\Modules\Approval\Api\Dto\ApprovalDto;

interface ApprovalFacadeInterface
{
    public function approve(ApprovalDto $entity): bool;

    public function reject(ApprovalDto $entity): bool;
}
