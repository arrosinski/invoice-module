<?php

namespace App\Modules\Invoices\Api\Dto;

use App\Infrastructure\HateoasLink;
use App\Modules\Invoices\Domain\Policies\CanChangeStatusPolicy;

class InvoicesLinks
{
    public static function index_links(): array
    {
        return [
            HateoasLink::create('self', route('invoices.index'))->toArray(),
        ];
    }

    public static function parse_list_links(array $invoices): array
    {
        return array_map(
            function ($invoice) {
                return InvoiceListViewModel::fromArray(
                    $invoice,
                    self::details_links($invoice->id, CanChangeStatusPolicy::check($invoice))
                );
            },
            $invoices
        );
    }

    public static function details_links(string $id, bool $canApprove): array
    {
        $links = [
            HateoasLink::create('self', route('invoices.show', ['id' => $id]))->toArray(),
        ];

        if ($canApprove) {
            $links = array_merge($links, self::approval_links($id));
        }

        return $links;
    }

    public static function show_links(string $id, bool $canApprove): array
    {
        return array_merge(
            self::details_links($id, $canApprove),
            [HateoasLink::create('index', route('invoices.index'))->toArray()]
        );
    }



    public static function approval_links(string $id): array {
        return [
            HateoasLink::create('approve', route('invoices.approve', ['id' => $id]), 'POST')->toArray(),
            HateoasLink::create('reject', route('invoices.reject', ['id' => $id]), 'POST')->toArray(),
        ];
    }
}
