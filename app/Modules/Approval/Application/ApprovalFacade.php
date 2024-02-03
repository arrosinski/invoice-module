<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use DomainException;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class ApprovalFacade implements ApprovalFacadeInterface
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    public function approve(ApprovalDto $entity): true
    {
        $this->validate($entity);
        $this->dispatcher->dispatch(new EntityApproved($entity));

        return true;
    }

    public function reject(ApprovalDto $entity): true
    {
        $this->validate($entity);
        $this->dispatcher->dispatch(new EntityRejected($entity));

        return true;
    }

    private function validate(ApprovalDto $dto): void
    {
        if (!$dto->status->equalsTo(StatusEnum::DRAFT)) {
            throw new DomainException('approval status is already assigned');
        }
    }
}
