<?php

declare(strict_types=1);

namespace Tests\Unit\Facades;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Approval\Application\ApprovalFacade;
use Illuminate\Contracts\Events\Dispatcher;
use LogicException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ApprovalFacadeTest extends TestCase
{
    private ApprovalFacade $approvalFacade;
    private Dispatcher $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = $this->createMock(Dispatcher::class);
        $this->approvalFacade = new ApprovalFacade($this->dispatcher);
    }

    public function testApprove(): void
    {
        $dto = new ApprovalDto(Uuid::uuid4(), StatusEnum::DRAFT, 'invoice');
        $this->dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EntityApproved::class));

        $result = $this->approvalFacade->approve($dto);

        $this->assertTrue($result);
    }

    public function testReject(): void
    {
        $dto = new ApprovalDto(Uuid::uuid4(), StatusEnum::DRAFT, 'invoice');
        $this->dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EntityRejected::class));

        $result = $this->approvalFacade->reject($dto);

        $this->assertTrue($result);
    }

    public function testValidateThrowsExceptionForInvalidStatus(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');

        $dto = new ApprovalDto(Uuid::uuid4(), StatusEnum::APPROVED, 'invoice');
        $this->approvalFacade->approve($dto);
    }
}
