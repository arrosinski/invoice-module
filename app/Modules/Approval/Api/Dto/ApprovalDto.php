<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api\Dto;

use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;
use Illuminate\Http\Request;
use InvalidArgumentException;

final readonly class ApprovalDto
{
    /** @param string $entity */
    public function __construct(
        public string $id,
        public StatusEnum $status,
        public string $entity,
    ) {
        if (!class_exists($entity)) {
            throw new InvalidArgumentException('Entity class does not exist');
        }
    }

    public static function fromRequest(Request $request): ApprovalDto
    {
        /** @noinspection PhpParamsInspection */
        return new self(
            $request->input('id'),
            $request->enum('status', StatusEnum::class),
            $request->input('entity'),
        );
    }
}
