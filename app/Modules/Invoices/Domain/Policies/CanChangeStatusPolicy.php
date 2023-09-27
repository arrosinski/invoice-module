<?php

namespace App\Modules\Invoices\Domain\Policies;

use App\Infrastructure\PolicyInterface;
use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;
use DomainException;
use Illuminate\Support\Facades\Log;

class CanChangeStatusPolicy implements PolicyInterface
{
    public final static function check($invoice, $user = null): bool
    {
        // if additional user related logic is needed, it can be placed here
        if ($invoice->status->value === StatusEnum::DRAFT->value) {
            return true;
        }
        return false;
    }

    public static function except($entity, $user = null): void
    {
        Log::debug('CanChangeStatusPolicy');
        if(!self::check($entity, $user)) {
            throw new DomainException('Invoice status cannot be changed');
        }
    }
}
