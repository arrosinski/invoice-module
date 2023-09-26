<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api;

use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Approval\Application\ApprovalFacadeInterface;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class ApprovalFacade implements ApprovalFacadeInterface
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    public function approve(ApprovalDto $dto): bool
    {
        $this->dispatcher->dispatch(new EntityApproved($dto));
        return true;
    }

    public function reject(ApprovalDto $dto): bool
    {
        $this->dispatcher->dispatch(new EntityRejected($dto));
        return true;
    }
}