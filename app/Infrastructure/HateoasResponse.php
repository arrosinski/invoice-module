<?php

namespace App\Infrastructure;

use Illuminate\Http\JsonResponse;

class HateoasResponse
{
    public function __construct(
        public array|object $data,
        public array $links,
    ) {
    }

    public static function create(array|object $data, array $links): self
    {
        self::validate($links);
        return new self($data, $links);
    }

    public function toResponse(): JsonResponse
    {
        return response()->json($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            '_links' => $this->links,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    private static function validate(array $links): void
    {
        if (empty($links)) {
            throw new \LogicException('links cannot be empty');
        }
    }
}
