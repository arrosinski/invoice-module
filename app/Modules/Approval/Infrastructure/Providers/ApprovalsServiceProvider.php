<?php

declare(strict_types=1);

namespace App\Modules\Approval\Infrastructure\Providers;

use App\Modules\Approval\Api\IdempotentApprovalFacade;
use App\Modules\Approval\Application\ApprovalFacadeInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ApprovalsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(ApprovalFacadeInterface::class, IdempotentApprovalFacade::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            ApprovalFacadeInterface::class,
        ];
    }
}
