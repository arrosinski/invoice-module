<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Domain\Enums\StatusEnum;
use Illuminate\Support\Facades\DB;
use stdClass;

trait FindInvoiceTrait
{
    protected function findFirst(?StatusEnum $status = null): ?stdClass
    {
        $invoices = DB::table('invoices')->get();

        if ($status !== null) {
            $invoices = $invoices->filter(static fn(stdClass $invoice) => $invoice->status == $status->value);
        }

        return $invoices->first();
    }
}
