<?php

declare(strict_types=1);

namespace App\Domain\Enums;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function fromString(string $status): self
    {
        return match ($status) {
            'draft' => self::DRAFT,
            'approved' => self::APPROVED,
            'rejected' => self::REJECTED,
            default => throw new \LogicException('Invalid status: '.$status),
        };
    }
}
