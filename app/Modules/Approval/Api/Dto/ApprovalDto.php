<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api\Dto;

use App\Modules\Invoices\Domain\ValueObjects\StatusEnum;

final readonly class ApprovalDto
{
    /** @param class-string $entity */
    public function __construct(
        public string $id,
        public StatusEnum $status,
        public string $entity,
    ) {
        if (!class_exists($entity)) {
            throw new \InvalidArgumentException('Entity class does not exist');
        }
    }

    public static function fromRequest(\Illuminate\Http\Request $request): ApprovalDto
    {
        return new self(
            $request->input('id'),
            $request->enum('status', StatusEnum::class),
            $request->input('entity'),
        );
    }
}
